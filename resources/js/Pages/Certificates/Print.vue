<template>
  <div>
    <div id="pdf-generate-wrapper">
      <img id="watermark" :src="watermark_src" width="30%" height="30%" />
      <div id="pdf-generate" class="max-w-screen-md m-auto p-2 pl-0 text-xs text-black bg-white mt-2">
        <div class="flex">
          <div class="w-4/6 pb-2 pl-2">
            <div class="flex">
              <div class="w-4/6 pb-2 pl-2 font-bold">
                <img :src="image_src" width="55%" height="55%" />
              </div>
              <div class="w-2/6 pb-2 pl-2 font-bold">Orginał | Kopia</div>
            </div>
          </div>
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
              <span class="text-blue-800 text-xxs"><span class="font-bold">1 Wjazd</span>/Einfahrt/Arrival:</span> <div class="font-bold">{{ certificate.date_of_arrival }}</div>
            </p>
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">Wyjazd</span>/Klant/Departure:</span> <div class="font-bold">{{ certificate.date_of_departure }}</div>
            </p>
          </div>
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">2 Seria</span> / Serien-Nummer / Serial Number</span>
            </p>
            <p class="text-red-500 font-bold">
              {{ certificate.series }} - {{ certificate.id }}
            </p>
          </div>
        </div>
        <div class="flex border-r border-l border-blue-500 border-t-0">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">3 Nazwa Firmy</span> / Klant / Client / Customer</span>
            </p>
            <p class="font-bold">
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
              <span class="text-blue-800 text-xxs"><span class="font-bold">4 Numer Identifikacyjny</span> / Identificatiner / NO d'identification / Identification Number</span>
              <br />
              <span class="text-blue-800 text-xxs"><span class="font-bold">Pojazd</span> / Fahrzeug / Vehicule / Vehicle</span>
            </p>
            <br />
            <p class="font-bold">
              {{ certificate.tractor }}
            </p>
            <br />
            <p>
              <span class="text-blue-800 text-xxs">
                <span class="font-bold">Cysterna</span>, Tank-kontener / Tankwagen,
                <br />
                Tank-kontener / Cisterne, Conteneur / Tank, Container
              </span>
            </p>
            <br />
            <p class="font-bold">
              {{ certificate.bowser }}
            </p>
            <br />
            <p class="font-bold">
              {{ certificate.container }}
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0 border-b-0 min-h-xs">
          <div class="w-1/2 border border-t-0 border-b-0 border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">5 Zakres Mycia</span> / Waschen Bereich / Prestations complementaires / Additional Service</span>
            </p>
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">EFTCO Code   Opis</span> / Beschreibung / Deskripcjon / Description</span>
            </p>
          </div>
          <div class="w-1/2 border border-t-0 border-b-0 border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">6 Procedura Mycia</span> / Prozedur Bereich / Procedures de lavage / Cleaning Procedures</span>
            </p>
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">EFTCO Code   Opis</span> / Beschreibung / Deskripcjon / Description</span>
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0 min-h-xs">
          <div class="w-1/2 border-l border-r border-blue-500 px-2">
            <div>
              <div class="flex">
                <div class="w-4/4">
                  <span v-for="washing_range in certificate.washing_ranges" :key="washing_range.id" class="font-bold">
                    {{ washing_range.name }}<br />
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="w-1/2 border-r border-l border-blue-500 px-2">
            <div>
              <div class="flex">
                <div class="w-4/4">
                  <span v-for="washing_procedure in certificate.washing_procedures" :key="washing_procedure.id" class="font-bold">
                    {{ washing_procedure.name }}<br />
                  </span>
                  <br />
                  <span v-for="detergent in certificate.detergents" :key="detergent.id" class="font-bold">
                    {{ detergent.name }}<br />
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0 min-h-xs">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">7 Komora</span> / Chamber / Kammer</span>
              <div class="w-4/4 font-bold">
                  {{ certificate.chamber }}
                </div>
            </p>
          </div>
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">8 Przegroda</span> / Partition / Trennwand</span>
              <div class="w-4/4 font-bold">
                  {{ certificate.partitions }}
                </div>
            </p>
          </div>
        </div>
        <div class="flex border border-t-0 border-blue-500 min-h-xs">
          <div class="w-full border-l border-r border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">9 Ostatni produkt</span> / Letze Produkt / Demier Produit Transporte / Previous load
              Nazwa / Nom / Name</span>
            </p>
            <div class="font-bold text-center">{{ certificate.last_product }}</div>
          </div>
        </div>
        <div class="flex border border-blue-500 min-h-xs">
          <div class="w-full border-r border-l border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">10 Komentarz</span> / Erklarung / Observations / Comments</span>
            </p>
            <p class="font-bold">
              Cysterne oplombowano plombami nr: {{ certificate.seals }}
            </p>
          </div>
        </div>
        <div class="flex border border-blue-500 border-t-0 min-h-sm">
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800 text-xxs"><span class="font-bold">12 Pieczatka</span> / Stamp / Stempel</span>
              <br />
              <span class="font-bold">Nazwisko imie name / Nom</span>
            </p>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <p class="font-bold">
              Podpis / Utershift / Signature
            </p>
          </div>
          <div class="w-1/2 border border-blue-500 px-2">
            <p>
              <span class="text-blue-800 font-bold text-xxs">11 Kierowca oswiadcza ze sprawdzil czystosc wymytej cysterny oraz plomby</span>
            </p>
            <br />
            <p>
              <span class="text-blue-800 font-bold text-xxs">13 Kierowca / Fahrer / Conducteur / Driver</span>
              <br />
              <span class="font-bold">Nazwisko imie / Name / Nom</span>
            </p>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <p class="font-bold">
              <i>{{ certificate.driver[0].first_name }} {{ certificate.driver[0].last_name }}</i>
            </p>
            <p class="font-bold">
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
        // image: { type: 'jpeg', quality: 0.98 },
        image: { type: 'jpg', quality: 1 },
        html2canvas: { scale: 3 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
      }
      html2pdf.default( element, opt )
    }
  },
}
</script>
