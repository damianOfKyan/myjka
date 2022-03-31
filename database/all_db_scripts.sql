-- CERT KON ADDRESS TO INSERT CONTACTS

INSERT INTO example_app.contacts 
(
	example_app.contacts.address,
	example_app.contacts.postal_code,
	example_app.contacts.city,
	example_app.contacts.country
)
SELECT 
	movedb.certyfikaty.cer_kon_ulica,
	movedb.certyfikaty.cer_kon_kod_pocztowy,
	movedb.certyfikaty.cer_kon_miasto,
	movedb.certyfikaty.cer_kon_kraj
FROM 
	movedb.certyfikaty
GROUP BY
	movedb.certyfikaty.cer_kon_ulica,
	movedb.certyfikaty.cer_kon_kod_pocztowy,
	movedb.certyfikaty.cer_kon_miasto,
	movedb.certyfikaty.cer_kon_kraj;

-- KON ADDRESS TO INSERT CONTACTS
INSERT INTO example_app.contacts 
(
	example_app.contacts.address,
	example_app.contacts.postal_code,
	example_app.contacts.city,
	example_app.contacts.country
)
SELECT 
	movedb.kontrahenci.kon_ulica,
	movedb.kontrahenci.kon_kod_pocztowy,
	movedb.kontrahenci.kon_miasto,
	movedb.kontrahenci.kon_kraj
FROM 
	movedb.kontrahenci
GROUP BY
	movedb.kontrahenci.kon_ulica,
	movedb.kontrahenci.kon_kod_pocztowy,
	movedb.kontrahenci.kon_miasto,
	movedb.kontrahenci.kon_kraj;

-- KON TO INSERT TO KON
INSERT IGNORE INTO example_app.contractors 
(
	example_app.contractors.id,
	example_app.contractors.code,
	example_app.contractors.name,
	example_app.contractors.nip,
	example_app.contractors.contact_id
)
SELECT
	movedb.kontrahenci.kon_id,
	movedb.kontrahenci.kon_kod,
	movedb.kontrahenci.kon_nazwa,
	movedb.kontrahenci.kon_nip,
	(
		SELECT
			example_app.contacts.id
		FROM
			example_app.contacts
		WHERE
			example_app.contacts.address = movedb.kontrahenci.kon_ulica
		AND
			example_app.contacts.postal_code = movedb.kontrahenci.kon_kod_pocztowy
		AND
			example_app.contacts.city = movedb.kontrahenci.kon_miasto
		AND
			example_app.contacts.country = movedb.kontrahenci.kon_kraj
		LIMIT 1
	) AS contact_id
FROM 
	movedb.kontrahenci;
	
-- CERT-KON TO INSERT TO KON
INSERT IGNORE INTO example_app.contractors 
(
	example_app.contractors.id,
	example_app.contractors.name,
	example_app.contractors.nip,
	example_app.contractors.contact_id
)
SELECT
	movedb.certyfikaty.cer_kon_id,
	movedb.certyfikaty.cer_kon_nazwa,
	movedb.certyfikaty.cer_kon_nip,
	(
		SELECT
			example_app.contacts.id
		FROM
			example_app.contacts
		WHERE
			example_app.contacts.id = movedb.certyfikaty.cer_kon_id
	) AS contact_id
FROM 
	movedb.certyfikaty;	
	
-- CERT DRIVER NAME TO INSERT CONTACTS
INSERT INTO example_app.contacts 
(
	example_app.contacts.first_name,
	example_app.contacts.last_name
)
SELECT
SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ' '), '   ', ' '), '  ', ' '), ' ', 1) AS 'first_name',
SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ' '), '   ', ' '), '  ', ' '), ' ', 2), ' ', -1) AS 'last_name'
FROM
	movedb.certyfikaty
GROUP BY
SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ' '), '   ', ' '), '  ', ' '), ' ', 1),
SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ' '), '   ', ' '), '  ', ' '), ' ', 2), ' ', -1);
	
-- NEW INSERT CERT INTO CERT
INSERT IGNORE INTO example_app.certificates 
(
	example_app.certificates.contractor_id,
	example_app.certificates.driver_id,
	example_app.certificates.series,
	example_app.certificates.date_of_arrival,
	example_app.certificates.date_of_departure,
	example_app.certificates.tractor,
	example_app.certificates.bowser,
	example_app.certificates.container,
	example_app.certificates.last_product,
-- 	example_app.certificates.washing_range,
-- 	example_app.certificates.washing_procedure,
-- 	example_app.certificates.detergents,
	example_app.certificates.chamber,
	example_app.certificates.`partitions`,
	example_app.certificates.seals
)
SELECT
	(
		SELECT
			example_app.contractors.id
		FROM
			example_app.contractors
		WHERE
			example_app.contractors.id = movedb.certyfikaty.cer_kon_id
		OR
			example_app.contractors.nip = movedb.certyfikaty.cer_kon_nip
		LIMIT 1
	) AS contractor_id,
	(
		SELECT
			example_app.contacts.id
		FROM
			example_app.contacts
		WHERE
			-- movedb.certyfikaty.cer_nazwisko_kierowcy LIKE CONCAT(example_app.contacts.last_name, ' ', example_app.contacts.first_name, '%')
			-- REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ''), '   ', ' '), '  ', ' ') LIKE CONCAT(example_app.contacts.last_name, ' ', example_app.contacts.first_name, '%')
			-- REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ''), '   ', ' '), '  ', ' ') LIKE CONCAT(example_app.contacts.first_name, ' ', example_app.contacts.last_name, '%')
			CONCAT(
				SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ' '), '   ', ' '), '  ', ' '), ' ', 1),
				' ',
				SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(movedb.certyfikaty.cer_nazwisko_kierowcy, '    ', ' '), '   ', ' '), '  ', ' '), ' ', 2), ' ', -1)
			) LIKE CONCAT(example_app.contacts.first_name, ' ', example_app.contacts.last_name, '%')
		LIMIT 1
	) AS driver_id,
	movedb.certyfikaty.cer_seria,
	IF(movedb.certyfikaty.cer_data_wjazdu IS NULL, movedb.certyfikaty.cer_data_wyjazdu, movedb.certyfikaty.cer_data_wjazdu),
	IF(movedb.certyfikaty.cer_data_wyjazdu IS NULL, movedb.certyfikaty.cer_data_wjazdu, movedb.certyfikaty.cer_data_wyjazdu),
	movedb.certyfikaty.cer_nr_ciagnika,
	movedb.certyfikaty.cer_nr_cysterny,
	movedb.certyfikaty.cer_nr_kontenera,
	movedb.certyfikaty.cer_ostatni_produkt,
	-- movedb.certyfikaty.cer_zakres_mycia,
-- 	movedb.certyfikaty.cer_procedura_mycia,
-- 	movedb.certyfikaty.cer_srodki_myjace,
	movedb.certyfikaty.cer_komora,
	movedb.certyfikaty.cer_przegrody,
	movedb.certyfikaty.cer_numery_plomb
-- 	movedb.certyfikaty.cer_kon_nip
-- 	movedb.certyfikaty.cer_kon_ulica,
-- 	movedb.certyfikaty.cer_kon_kod_pocztowy,
-- 	movedb.certyfikaty.cer_kon_miasto,
-- 	movedb.certyfikaty.cer_nazwisko_kierowcy
FROM 
	movedb.certyfikaty;
	
-- INSERT WASHING RANGES
INSERT IGNORE INTO example_app.washing_ranges 
(
	example_app.washing_ranges.name
)
SELECT DISTINCT
	movedb.certyfikaty.cer_zakres_mycia
FROM 
	movedb.certyfikaty;

-- INSET CERT - WASHING RANGES - PIVOT
INSERT IGNORE INTO example_app.certificate_washing_range
(
	example_app.certificate_washing_range.certificate_id,
	example_app.certificate_washing_range.washing_range_id
)
SELECT
	(
		SELECT
			example_app.certificates.id
		FROM
			example_app.certificates
		WHERE
			example_app.certificates.series = movedb.certyfikaty.cer_seria	
	) AS 'certificate_id',
	(
		SELECT
			example_app.washing_ranges.id
		FROM
			example_app.washing_ranges
		WHERE
			example_app.washing_ranges.name = movedb.certyfikaty.cer_zakres_mycia
	) AS 'washing_range_id'
FROM 
	movedb.certyfikaty
WHERE
	(
		SELECT
			example_app.certificates.id
		FROM
			example_app.certificates
		WHERE
			example_app.certificates.series = movedb.certyfikaty.cer_seria	
	) IS NOT NULL
GROUP BY 
	movedb.certyfikaty.cer_seria,
	movedb.certyfikaty.cer_zakres_mycia;


-- INSERT WASHING PROCEDURES
INSERT IGNORE INTO example_app.washing_procedures 
(
	example_app.washing_procedures.name
)
SELECT DISTINCT
	movedb.certyfikaty.cer_procedura_mycia
FROM 
	movedb.certyfikaty;
	
-- INSERT CERT - WASHING PROCEDURES - PIVOT
INSERT IGNORE INTO example_app.certificate_washing_procedure
(
	example_app.certificate_washing_procedure.certificate_id,
	example_app.certificate_washing_procedure.washing_procedure_id
)
SELECT
	(
		SELECT
			example_app.certificates.id
		FROM
			example_app.certificates
		WHERE
			example_app.certificates.series = movedb.certyfikaty.cer_seria	
	) AS 'certificate_id',
	(
		SELECT
			example_app.washing_procedures.id
		FROM
			example_app.washing_procedures
		WHERE
			example_app.washing_procedures.name = movedb.certyfikaty.cer_procedura_mycia
	) AS 'washing_procedure_id'
FROM 
	movedb.certyfikaty
WHERE
	(
		SELECT
			example_app.certificates.id
		FROM
			example_app.certificates
		WHERE
			example_app.certificates.series = movedb.certyfikaty.cer_seria	
	) IS NOT NULL
GROUP BY 
	movedb.certyfikaty.cer_seria,
	movedb.certyfikaty.cer_procedura_mycia;

-- INSERT DETERGENTS
INSERT IGNORE INTO example_app.detergents 
(
	example_app.detergents.name
)
SELECT DISTINCT
	movedb.certyfikaty.cer_srodki_myjace
FROM 
	movedb.certyfikaty;

-- INSERT CERT - DETERGENTS - PIVOT
INSERT IGNORE INTO example_app.certificate_detergent
(
	example_app.certificate_detergent.certificate_id,
	example_app.certificate_detergent.detergent_id
)
SELECT
	(
		SELECT
			example_app.certificates.id
		FROM
			example_app.certificates
		WHERE
			example_app.certificates.series = movedb.certyfikaty.cer_seria	
	) AS 'certificate_id',
	(
		SELECT
			example_app.detergents.id
		FROM
			example_app.detergents
		WHERE
			example_app.detergents.name = movedb.certyfikaty.cer_srodki_myjace
	) AS 'detergent_id'
FROM 
	movedb.certyfikaty
WHERE
	(
		SELECT
			example_app.certificates.id
		FROM
			example_app.certificates
		WHERE
			example_app.certificates.series = movedb.certyfikaty.cer_seria	
	) IS NOT NULL
GROUP BY 
	movedb.certyfikaty.cer_seria,
	movedb.certyfikaty.cer_srodki_myjace;
