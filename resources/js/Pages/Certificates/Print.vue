<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates')">Certificates</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates.edit', certificate.id)">{{ certificate.series }}</inertia-link>
    </h1>
    <button class="text-white btn-indigo ml-auto hover:underline" tabindex="-1" type="button" @click="generatePdf">Generate PDF</button>

    <div id="pdf-generate" class="max-w-screen-md m-auto p-4 text-sm">
      <div class="flex">
        <div class="w-1/2 ">LOGO</div>
        <div class="w-1/2 text-center text-white bg-blue-500 text-lg">
          <h1 class="bg-blue-500">Certyfikat Czystosci</h1>
          <h2>Cleaning Document</h2>
        </div>
      </div>
      <div class="flex">
        <div class="w-full border border-blue-500">
          <div class="flex">
            <div class="w-3/5 p-2">
              <p>
                Myjnia Cystern Samochodowych
              </p>
              <p>
                TANKWAGEN TANKWAGEN
                TANKWAGENTANKWAGEN
                TANKWAGEN
              </p>
            </div>
            <div class="w-2/5 p-2">
              <p>
                Carchem II Cwiklik Piotr
                <br />
                ul. Lukasiewicza 1
                <br />
                78-400 Szczecinek
                <br />
                Polska
                <br />
                NIP - PL9930070175
                <br />
                tel. 0048 503 178 886
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            1
          </p>
          <p>
            Wjazd/Einfahrt/Arrival: 2020-12-10
          </p>
          <p>
            Wyjazd/Klant/Departure: 2020-12-10
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            2
          </p>
          <p>
            Seria / Serien-Nummer / Serial Number
          </p>
          <p>
            PL 20128441
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            3 Nazwa Firmy / Klant / Client / Customer
          </p>
          <p>
            Poltank Siegfried Hansen sp.j.
            Tomaszowek 1A
            26-332 Sławno
            Polska
            NIP: 768-182-59-51
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            4 Numer Identifikacyjny / Identificatiner / N0 d'identification / Identification Number
            <br>
            Pojazd / Fahrzeug / Vehicule / Vehicle
          </p>
          <p>
            EOPCT16
          </p>
          <p>
            Cysterna, Tank-kontener / Tankwagen, Tank-kontener / Cisterne, Conteneur / Tank, Container
          </p>
          <p>
            SLPC840
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            5 Zakres Mycia / Waschen Bereich / Prestations complementaires / Additional Service
          </p>
          <p>
            EFTCO Code   Opis / Beschreibung / Deskripcjon / Description
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            6 Procedura Mycia / Prozedur Bereich / Procedures de lavage / Cleaning Procedures
          </p>
          <p>
            EFTCO Code   Opis / Beschreibung / Deskripcjon / Description
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <div>
            <div class="flex">
              <div class="w-1/4">
                <p>
                  E50
                </p>
                <p>
                  E55
                </p>
                <p>
                  E01
                </p>
                <p>
                  E99
                </p>
              </div>
              <div class="w-3/4">
                <p>
                  Wszystkie Przegrody
                </p>
                <p>
                  Weze
                </p>
                <p>
                  Akcesoria
                </p>
                <p>
                  Wlazy i zawory
                </p>
                <p>
                  Inne czynnosci
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="w-1/2 p-2">
          <div>
            <div class="flex">
              <div class="w-1/4">
                <p>
                  C01
                </p>
                <p>
                  P01
                </p>
                <p>
                  P10
                </p>
                <p>
                  P40
                </p>
              </div>
              <div class="w-3/4">
                <p>
                  Srodek myjacy
                </p>
                <p>
                  Zimna woda
                </p>
                <p>
                  Goraca woda
                </p>
                <p>
                  Parowanie
                </p>
                <p>
                  Suczenie
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-full p-2">
          <p>
            7 Ostatni produkt / Letze Produkt / Demier Produit Transporte / Previous load
            Nazwa / Nom / Name
          </p>
          <p>
            Hydrowax, Glycerin, Rizinusoel
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-full p-2">
          <p>
            8 Komentarz / Erklarung / Observations / Comments
          </p>
          <p>
            Cysterne oplombowano plombami nr
          </p>
          <p>
            A10316441-A10316446
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-full p-2">
          <p>
            Kierowca oswiadcza ze sprawdzil czystosc wymytej cysterny oraz plomby
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            10 Pieczatka / Stamp / Stempel
            <br />
            Nazwisko imie name / Nom
          </p>
          <br />
          <p>
            Podpis / Utershift / Signature
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            11 Kierowca / Fahrer / Conducteur / Driver
            <br />
            Nazwisko imie / Name / Nom
          </p>
          <br />
          <p>
            Rudnyk Bogdan
          </p>
          <br />
          <p>
            Podpis / Utershift / Signature
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import * as html2pdf from 'html2pdf.js'

export default {
  layout: Layout,
  props: {
    certificate: Object,
  },
  mounted: () => {



  },
  methods: {
    generatePdf() {
      var element = document.getElementById('pdf-generate')
      const opt = {
        // margin: 0,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 1 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
      }
      html2pdf.default( element, opt )
    }
  },
}
</script>
