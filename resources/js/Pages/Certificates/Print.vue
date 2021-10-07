<template>
  <div>
    <h1 class="mb-8 font-sans font-bold text-3xl">
      <inertia-link class="text-black hover:text-indigo-600" :href="route('certificates')">{{ translate('messages.Certificates.Index.Self') }}</inertia-link>
      <span class="text-black font-medium">/</span>
      <inertia-link class="text-red-600 hover:text-red-400" :href="route('certificates.edit', certificate.id)">{{ certificate.series }}</inertia-link>
    </h1>
    <button class="text-white btn-indigo ml-auto hover:underline mb-8" tabindex="-1" type="button" @click="generatePdf">{{ translate('messages.GeneratePDF') }}</button>

    <div id="pdf-generate-wrapper">
      <img id="watermark" :src="watermark_src" width="30%" height="30%" />
      <div id="pdf-generate" class="max-w-screen-md m-auto p-2 pl-0 text-sm text-black bg-white mt-2">
        <div class="flex">
          <div class="w-3/6 pb-2 pl-2"><img :src="image_src" width="35%" height="35%" /></div>
          <div class="w-1/6 pb-2 pl-2">Orginał | Kopia</div>
          <div class="w-2/6 text-center text-white bg-blue-500 text-lg">
            <h1 class="bg-blue-500">Certyfikat Czystości</h1>
            <h2>Cleaning Document</h2>
          </div>
        </div>
        <div class="flex">
          <div class="w-full border border-blue-500 font-bold">
            <div class="flex">
              <div class="w-1/2 border border-blue-500 px-2">
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
              <div class="w-1/2 border border-blue-500 px-2">
                <p>
                  MRC Carchem II, Ćwiklik Piotr
                  <br />
                  ul. Gospodarcza 3
                  <br />
                  68-200 Żary, Polska
                  <br />
                  NIP - PL9930070175
                  <br />
                  kontakt: tel. 0048 503 178 886,
                  <br />
                  e-mail: piotrcarchem@op.pl
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0">
          <div class="w-1/2 border-l border-r border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">1 Wjazd</span>/Einfahrt/Arrival:</span> {{ certificate.date_of_arrival }}
            </p>
            <p>
              <span class="text-blue-800"><span class="font-bold">Wyjazd</span>/Klant/Departure:</span> {{ certificate.date_of_departure }}
            </p>
          </div>
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">2 Seria</span> / Serien-Nummer / Serial Number</span>
            </p>
            <p class="text-red-500 font-bold">
              {{ certificate.series }}
            </p>
          </div>
        </div>
        <div class="flex border-r border-l border-blue-500 border-t-0">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">3 Nazwa Firmy</span> / Klant / Client / Customer</span>
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
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">4 Numer Identifikacyjny</span> / Identificatiner / NO d'identification / Identification Number</span>
              <br />
              <span class="text-blue-800"><span class="font-bold">Pojazd</span> / Fahrzeug / Vehicule / Vehicle</span>
            </p>
            <p>
              {{ certificate.tractor }}
            </p>
            <br />
            <p>
              <span class="text-blue-800">
                <span class="font-bold">Cysterna</span>, Tank-kontener / Tankwagen,
                <br />
                Tank-kontener / Cisterne, Conteneur / Tank, Container
              </span>
            </p>
            <p>
              {{ certificate.bowser }}
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">5 Zakres Mycia</span> / Waschen Bereich / Prestations complementaires / Additional Service</span>
            </p>
            <p>
              <span class="text-blue-800"><span class="font-bold">EFTCO Code   Opis</span> / Beschreibung / Deskripcjon / Description</span>
            </p>
          </div>
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">6 Procedura Mycia</span> / Prozedur Bereich / Procedures de lavage / Cleaning Procedures</span>
            </p>
            <p>
              <span class="text-blue-800"><span class="font-bold">EFTCO Code   Opis</span> / Beschreibung / Deskripcjon / Description</span>
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0">
          <div class="w-1/2 border-l border-r border-blue-500 px-2">
            <div>
              <div class="flex">
                <div class="w-4/4">
                  <span v-for="washing_range in certificate.washing_ranges" :key="washing_range.id">
                    {{ washing_range.name }},
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <div>
              <div class="flex">
                <div class="w-4/4">
                  <span v-for="washing_procedure in certificate.washing_procedures" :key="washing_procedure.id">
                    {{ washing_procedure.name }},
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">7 Komora</span> / Chamber / Kammer</span>
            </p>
          </div>
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">8 Przegroda</span> / Partition / Trennwand</span>
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0">
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <div>
              <div class="flex">
                <div class="w-4/4">
                  {{ certificate.chamber }}
                </div>
              </div>
            </div>
          </div>
          <div class="w-1/2 border-l border-r border-blue-500 px-2">
            <div>
              <div class="flex">
                <div class="w-4/4">
                  {{ certificate.partitions }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex border border-blue-500">
          <div class="w-full border-r border-l border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">9 Środki Myjące</span> / Detergents / Reinigungsmittel</span>
            </p>
            <span v-for="detergent in certificate.detergents" :key="detergent.id">
              {{ detergent.name }},
            </span>
          </div>
        </div>
        <div class="flex border border-blue-500">
          <div class="w-full border-l border-r border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">10 Ostatni produkt</span> / Letze Produkt / Demier Produit Transporte / Previous load
              Nazwa / Nom / Name</span>
            </p>
            {{ certificate.last_product }}
          </div>
        </div>
        <div class="flex border border-blue-500">
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">11 Komentarz</span> / Erklarung / Observations / Comments</span>
            </p>
            <p>
              Cysterne oplombowano plombami nr: {{ certificate.seals }}
            </p>
          </div>
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <p>
              <span class="text-blue-800 font-bold">12 Kierowca oswiadcza ze sprawdzil czystosc wymytej cysterny oraz plomby</span>
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800"><span class="font-bold">13 Pieczatka</span> / Stamp / Stempel</span>
              <br />
              Nazwisko imie name / Nom
            </p>
            <br />
            <br />
            <br />
            <p>
              Podpis / Utershift / Signature
            </p>
          </div>
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800 font-bold">14 Kierowca / Fahrer / Conducteur / Driver</span>
              <br />
              Nazwisko imie / Name / Nom
            </p>
            <br />
            <br />
            <br />
            <p>
              <i>{{ certificate.driver[0].first_name }} {{ certificate.driver[0].last_name }}</i>
            </p>
            <p>
              Podpis / Utershift / Signature
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PrintLayout from '@/Shared/PrintLayout'
import * as html2pdf from 'html2pdf.js'

export default {
  layout: PrintLayout,
  props: {
    certificate: Object,
    logo: Object,
  },
  data: () => {
    return {
      image_src: '/assets/logo.png',
      watermark_src: '/assets/logo_grey.png',
    }
  },
  mounted: () => {},
  methods: {
    generatePdf() {
      var element = document.getElementById('pdf-generate-wrapper')
      const opt = {
        margin: 0,
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
