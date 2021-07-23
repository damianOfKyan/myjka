<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates')">{{ translate('messages.Certificates.Index.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates.edit', certificate.id)">{{ certificate.series }}</inertia-link>
    </h1>
    <button class="text-white btn-indigo ml-auto hover:underline" tabindex="-1" type="button" @click="generatePdf">{{ translate('messages.GeneratePDF') }}</button>

    <div id="pdf-generate" class="max-w-screen-md m-auto p-2 text-sm bg-white mt-10">
      <div class="flex">
        <div class="w-1/2 "><img :src="image_src" /></div>
        <div class="w-1/2 text-center text-white bg-blue-500 text-lg">
          <h1 class="bg-blue-500">Certyfikat Czystości</h1>
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
                TANKWAGEN WASCHANLAGE
                <br />
                LA STATION DE LAVAGE
                <br />
                CLEANING STATION
              </p>
            </div>
            <div class="w-2/5 p-2">
              <p>
                MRC Carchem II Ćwiklik Piotr
                <br />
                ul. Gospodarcza 3
                <br />
                68-200 Żary
                <br />
                Polska
                <br />
                NIP - PL9930070175
                <br />
                tel. 0048 503 178 886
                <br />
                piotrcarchem@op.pl
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            <strong>1</strong>
          </p>
          <p>
            <strong>Wjazd/Einfahrt/Arrival:</strong> {{ certificate.date_of_arrival }}
          </p>
          <p>
            <strong>Wyjazd/Klant/Departure:</strong> {{ certificate.date_of_departure }}
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            <strong>2</strong>
          </p>
          <p>
            <strong>Seria / Serien-Nummer / Serial Number</strong>
          </p>
          <p>
            {{ certificate.series }}
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            <strong>3 Nazwa Firmy / Klant / Client / Customer</strong>
          </p>
          <p>
            {{ certificate.contractor.name }}
            <br />
            {{ certificate.contractor.address }}
            <br />
            {{ certificate.contractor.postal_code }}
            <br />
            {{ certificate.contractor.city }}
            <br />
            {{ certificate.contractor.country }}
            <br />
            NIP: {{ certificate.contractor.nip }}
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            <strong>4 Numer Identifikacyjny / Identificatiner / NO d'identification / Identification Number</strong>
            <br />
            <strong>Pojazd / Fahrzeug / Vehicule / Vehicle</strong>
          </p>
          <p>
            {{ certificate.tractor }}
          </p>
          <br />
          <p>
            <strong>Cysterna, Tank-kontener / Tankwagen, Tank-kontener / Cisterne, Conteneur / Tank, Container</strong>
          </p>
          <p>
            {{ certificate.bowser }}
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            <strong>5 Zakres Mycia / Waschen Bereich / Prestations complementaires / Additional Service</strong>
          </p>
          <p>
            <strong>EFTCO Code   Opis / Beschreibung / Deskripcjon / Description</strong>
          </p>
        </div>
        <div class="w-1/2 p-2">
          <p>
            <strong>6 Procedura Mycia / Prozedur Bereich / Procedures de lavage / Cleaning Procedures</strong>
          </p>
          <p>
            <strong>EFTCO Code   Opis / Beschreibung / Deskripcjon / Description</strong>
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
            <strong>7 Ostatni produkt / Letze Produkt / Demier Produit Transporte / Previous load
            Nazwa / Nom / Name</strong>
          </p>
          <p>
            Hydrowax, Glycerin, Rizinusoel
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-full p-2">
          <p>
            <strong>8 Komentarz / Erklarung / Observations / Comments</strong>
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
            <strong>9 Kierowca oswiadcza ze sprawdzil czystosc wymytej cysterny oraz plomby</strong>
          </p>
        </div>
      </div>
      <div class="flex border border-blue-500 border-t-0">
        <div class="w-1/2 p-2">
          <p>
            <strong>10 Pieczatka / Stamp / Stempel</strong>
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
            <strong>11 Kierowca / Fahrer / Conducteur / Driver</strong>
            <br />
            Nazwisko imie / Name / Nom
          </p>
          <br />
          <p>
            Rudnyk Bogdan
          </p>
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
    logo: Object,
  },
  data: () => {
    return {
      image_src: '/assets/logo.jpg',
    }
  },
  mounted: () => {},
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
