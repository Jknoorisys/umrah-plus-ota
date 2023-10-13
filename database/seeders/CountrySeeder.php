<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entries = [
            [
              "name"=> "افغانستان",
              "code"=> "AF",
              "phone_code"=> "+93",
            ],
            [
              "name"=> "Åland",
              "code"=> "AX",
              "phone_code"=> "+358",
            ],
            [
              "name"=> "Shqipëria",
              "code"=> "AL",
              "phone_code"=> "+355",
            ],
            [
              "name"=> "الجزائر",
              "code"=> "DZ",
              "phone_code"=> "+213",
            ],
            [
              "name"=> "American Samoa",
              "code"=> "AS",
              "phone_code"=> "+1684",
            ],
            [
              "name"=> "Andorra",
              "code"=> "AD",
              "phone_code"=> "+376",
            ],
            [
              "name"=> "Angola",
              "code"=> "AO",
              "phone_code"=> "+244",
            ],
            [
              "name"=> "Anguilla",
              "code"=> "AI",
              "phone_code"=> "+1264",
            ],
            [
              "name"=> "Antarctica",
              "code"=> "AQ",
              "phone_code"=> "+672",
            ],
            [
              "name"=> "Antigua and Barbuda",
              "code"=> "AG",
              "phone_code"=> "+1268",
            ],
            [
              "name"=> "Argentina",
              "code"=> "AR",
              "phone_code"=> "+54",
            ],
            [
              "name"=> "Հայաստան",
              "code"=> "AM",
              "phone_code"=> "+374",
            ],
            [
              "name"=> "Aruba",
              "code"=> "AW",
              "phone_code"=> "+297",
            ],
            [
              "name"=> "Australia",
              "code"=> "AU",
              "phone_code"=> "+61",
            ],
            [
              "name"=> "Österreich",
              "code"=> "AT",
              "phone_code"=> "+43",
            ],
            [
              "name"=> "Azərbaycan",
              "code"=> "AZ",
              "phone_code"=> "+994",
            ],
            [
              "name"=> "Bahamas",
              "code"=> "BS",
              "phone_code"=> "+1242",
            ],
            [
              "name"=> "لبحرين",
              "code"=> "BH",
              "phone_code"=> "+973",
            ],
            [
              "name"=> "Bangladesh",
              "code"=> "BD",
              "phone_code"=> "+880",
            ],
            [
              "name"=> "Barbados",
              "code"=> "BB",
              "phone_code"=> "+1246",
            ],
            [
              "name"=> "Белару́сь",
              "code"=> "BY",
              "phone_code"=> "+375",
            ],
            [
              "name"=> "België",
              "code"=> "BE",
              "phone_code"=> "+32",
            ],
            [
              "name"=> "Belize",
              "code"=> "BZ",
              "phone_code"=> "+501",
            ],
            [
              "name"=> "Bénin",
              "code"=> "BJ",
              "phone_code"=> "+229",
            ],
            [
              "name"=> "Bermuda",
              "code"=> "BM",
              "phone_code"=> "+1441",
            ],
            [
              "name"=> "brug-yul",
              "code"=> "BT",
              "phone_code"=> "+975",
            ],
            [
              "name"=> "Bolivia",
              "code"=> "BO",
              "phone_code"=> "+591",
            ],
            [
              "name"=> "Bosna i Hercegovina",
              "code"=> "BA",
              "phone_code"=> "+387",
            ],
            [
              "name"=> "Botswana",
              "code"=> "BW",
              "phone_code"=> "+267",
            ],
            [
              "name"=> "Bouvetøya",
              "code"=> "BV",
              "phone_code"=> "+47",
            ],
            [
              "name"=> "Brasil",
              "code"=> "BR",
              "phone_code"=> "+55",
            ],
            [
              "name"=> "British Indian Ocean Territory",
              "code"=> "IO",
              "phone_code"=> "+246",
            ],
            [
              "name"=> "Negara Brunei Darussalam",
              "code"=> "BN",
              "phone_code"=> "+673",
            ],
            [
              "name"=> "България",
              "code"=> "BG",
              "phone_code"=> "+359",
            ],
            [
              "name"=> "Burkina Faso",
              "code"=> "BF",
              "phone_code"=> "+226",
            ],
            [
              "name"=> "Burundi",
              "code"=> "BI",
              "phone_code"=> "+257",
            ],
            [
              "name"=> "Kâmpŭchéa",
              "code"=> "KH",
              "phone_code"=> "+855",
            ],
            [
              "name"=> "Cameroon",
              "code"=> "CM",
              "phone_code"=> "+237",
            ],
            [
              "name"=> "Canada",
              "code"=> "CA",
              "phone_code"=> "+1",
            ],
            [
              "name"=> "Cabo Verde",
              "code"=> "CV",
              "phone_code"=> "+238",
            ],
            [
              "name"=> "Cayman Islands",
              "code"=> "KY",
              "phone_code"=> "+ 345",
            ],
            [
              "name"=> "Ködörösêse tî Bêafrîka",
              "code"=> "CF",
              "phone_code"=> "+236",
            ],
            [
              "name"=> "Tchad",
              "code"=> "TD",
              "phone_code"=> "+235",
            ],
            [
              "name"=> "Chile",
              "code"=> "CL",
              "phone_code"=> "+56",
            ],
            [
              "name"=> "中国",
              "code"=> "CN",
              "phone_code"=> "+86",
            ],
            [
              "name"=> "Christmas Island",
              "code"=> "CX",
              "phone_code"=> "+61",
            ],
            [
              "name"=> "Cocos (Keeling) Islands",
              "code"=> "CC",
              "phone_code"=> "+61",
            ],
            [
              "name"=> "Colombia",
              "code"=> "CO",
              "phone_code"=> "+57",
            ],
            [
              "name"=> "Komori",
              "code"=> "KM",
              "phone_code"=> "+269",
            ],
            [
              "name"=> "République du Congo",
              "code"=> "CG",
              "phone_code"=> "+242",
            ],
            [
              "name"=> "République démocratique du Congo",
              "code"=> "CD",
              "phone_code"=> "+243",
            ],
            [
              "name"=> "Cook Islands",
              "code"=> "CK",
              "phone_code"=> "+682",
            ],
            [
              "name"=> "Costa Rica",
              "code"=> "CR",
              "phone_code"=> "+506",
            ],
            [
              "name"=> "Côte d'Ivoire",
              "code"=> "CI",
              "phone_code"=> "+225",
            ],
            [
              "name"=> "Hrvatska",
              "code"=> "HR",
              "phone_code"=> "+385",
            ],
            [
              "name"=> "Cuba",
              "code"=> "CU",
              "phone_code"=> "+53",
            ],
            [
              "name"=> "Κύπρος",
              "code"=> "CY",
              "phone_code"=> "+357",
            ],
            [
              "name"=> "Česká republika",
              "code"=> "CZ",
              "phone_code"=> "+420",
            ],
            [
              "name"=> "Danmark",
              "code"=> "DK",
              "phone_code"=> "+45",
            ],
            [
              "name"=> "Djibouti",
              "code"=> "DJ",
              "phone_code"=> "+253",
            ],
            [
              "name"=> "Dominica",
              "code"=> "DM",
              "phone_code"=> "+1767",
            ],
            [
              "name"=> "República Dominicana",
              "code"=> "DO",
              "phone_code"=> "+1",
            ],
            [
              "name"=> "Ecuador",
              "code"=> "EC",
              "phone_code"=> "+593",
            ],
            [
              "name"=> "مصر",
              "code"=> "EG",
              "phone_code"=> "+20",
            ],
            [
              "name"=> "El Salvador",
              "code"=> "SV",
              "phone_code"=> "+503",
            ],
            [
              "name"=> "Guinea Ecuatorial",
              "code"=> "GQ",
              "phone_code"=> "+240",
            ],
            [
              "name"=> "ኤርትራ",
              "code"=> "ER",
              "phone_code"=> "+291",
            ],
            [
              "name"=> "Eesti",
              "code"=> "EE",
              "phone_code"=> "+372",
            ],
            [
              "name"=> "ኢትዮጵያ",
              "code"=> "ET",
              "phone_code"=> "+251",
            ],
            [
              "name"=> "Falkland Islands",
              "code"=> "FK",
              "phone_code"=> "+500",
            ],
            [
              "name"=> "Føroyar",
              "code"=> "FO",
              "phone_code"=> "+298",
            ],
            [
              "name"=> "Fiji",
              "code"=> "FJ",
              "phone_code"=> "+679",
            ],
            [
              "name"=> "Suomi",
              "code"=> "FI",
              "phone_code"=> "+358",
            ],
            [
              "name"=> "France",
              "code"=> "FR",
              "phone_code"=> "+33",
            ],
            [
              "name"=> "Guyane française",
              "code"=> "GF",
              "phone_code"=> "+594",
            ],
            [
              "name"=> "Polynésie française",
              "code"=> "PF",
              "phone_code"=> "+689",
            ],
            [
              "name"=> "Territoire des Terres australes et antarctiques fr",
              "code"=> "TF",
              "phone_code"=> "+262",
            ],
            [
              "name"=> "Gabon",
              "code"=> "GA",
              "phone_code"=> "+241",
            ],
            [
              "name"=> "Gambia",
              "code"=> "GM",
              "phone_code"=> "+220",
            ],
            [
              "name"=> "საქართველო",
              "code"=> "GE",
              "phone_code"=> "+995",
            ],
            [
              "name"=> "Deutschland",
              "code"=> "DE",
              "phone_code"=> "+49",
            ],
            [
              "name"=> "Ghana",
              "code"=> "GH",
              "phone_code"=> "+233",
            ],
            [
              "name"=> "Gibraltar",
              "code"=> "GI",
              "phone_code"=> "+350",
            ],
            [
              "name"=> "Ελλάδα",
              "code"=> "GR",
              "phone_code"=> "+30",
            ],
            [
              "name"=> "Kalaallit Nunaat",
              "code"=> "GL",
              "phone_code"=> "+299",
            ],
            [
              "name"=> "Grenada",
              "code"=> "GD",
              "phone_code"=> "+1473",
            ],
            [
              "name"=> "Guadeloupe",
              "code"=> "GP",
              "phone_code"=> "+590",
            ],
            [
              "name"=> "Guam",
              "code"=> "GU",
              "phone_code"=> "+1671",
            ],
            [
              "name"=> "Guatemala",
              "code"=> "GT",
              "phone_code"=> "+502",
            ],
            [
              "name"=> "Guernsey",
              "code"=> "GG",
              "phone_code"=> "+44",
            ],
            [
              "name"=> "Guinée",
              "code"=> "GN",
              "phone_code"=> "+224",
            ],
            [
              "name"=> "Guiné-Bissau",
              "code"=> "GW",
              "phone_code"=> "+245",
            ],
            [
              "name"=> "Guyana",
              "code"=> "GY",
              "phone_code"=> "+592",
            ],
            [
              "name"=> "Haïti",
              "code"=> "HT",
              "phone_code"=> "+509",
            ],
            [
              "name"=> "Heard Island and McDonald Islands",
              "code"=> "HM",
              "phone_code"=> "+0",
            ],
            [
              "name"=> "Vaticano",
              "code"=> "VA",
              "phone_code"=> "+379",
            ],
            [
              "name"=> "Honduras",
              "code"=> "HN",
              "phone_code"=> "+504",
            ],
            [
              "name"=> "香港",
              "code"=> "HK",
              "phone_code"=> "+852",
            ],
            [
              "name"=> "Magyarország",
              "code"=> "HU",
              "phone_code"=> "+36",
            ],
            [
              "name"=> "Ísland",
              "code"=> "IS",
              "phone_code"=> "+354",
            ],
            [
              "name"=> "भारत",
              "code"=> "IN",
              "phone_code"=> "+91",
            ],
            [
              "name"=> "Indonesia",
              "code"=> "ID",
              "phone_code"=> "+62",
            ],
            [
              "name"=> "ایران",
              "code"=> "IR",
              "phone_code"=> "+98",
            ],
            [
              "name"=> "العراق",
              "code"=> "IQ",
              "phone_code"=> "+964",
            ],
            [
              "name"=> "Éire",
              "code"=> "IE",
              "phone_code"=> "+353",
            ],
            [
              "name"=> "Isle of Man",
              "code"=> "IM",
              "phone_code"=> "+44",
            ],
            [
              "name"=> "יִשְׂרָאֵל",
              "code"=> "IL",
              "phone_code"=> "+972",
            ],
            [
              "name"=> "Italia",
              "code"=> "IT",
              "phone_code"=> "+39",
            ],
            [
              "name"=> "Jamaica",
              "code"=> "JM",
              "phone_code"=> "+1876",
            ],
            [
              "name"=> "日本",
              "code"=> "JP",
              "phone_code"=> "+81",
            ],
            [
              "name"=> "Jersey",
              "code"=> "JE",
              "phone_code"=> "+44",
            ],
            [
              "name"=> "الأردن",
              "code"=> "JO",
              "phone_code"=> "+962",
            ],
            [
              "name"=> "Қазақстан",
              "code"=> "KZ",
              "phone_code"=> "+7",
            ],
            [
              "name"=> "Kenya",
              "code"=> "KE",
              "phone_code"=> "+254",
            ],
            [
              "name"=> "Kiribati",
              "code"=> "KI",
              "phone_code"=> "+686",
            ],
            [
              "name"=> "북한",
              "code"=> "KP",
              "phone_code"=> "+850",
            ],
            [
              "name"=> "대한민국",
              "code"=> "KR",
              "phone_code"=> "+82",
            ],
            [
              "name"=> "Republika e Kosovës",
              "code"=> "XK",
              "phone_code"=> "+383",
            ],
            [
              "name"=> "الكويت",
              "code"=> "KW",
              "phone_code"=> "+965",
            ],
            [
              "name"=> "Кыргызстан",
              "code"=> "KG",
              "phone_code"=> "+996",
            ],
            [
              "name"=> "ສປປລາວ",
              "code"=> "LA",
              "phone_code"=> "+856",
            ],
            [
              "name"=> "Latvija",
              "code"=> "LV",
              "phone_code"=> "+371",
            ],
            [
              "name"=> "لبنان",
              "code"=> "LB",
              "phone_code"=> "+961",
            ],
            [
              "name"=> "Lesotho",
              "code"=> "LS",
              "phone_code"=> "+266",
            ],
            [
              "name"=> "Liberia",
              "code"=> "LR",
              "phone_code"=> "+231",
            ],
            [
              "name"=> "يبيا",
              "code"=> "LY",
              "phone_code"=> "+218",
            ],
            [
              "name"=> "Liechtenstein",
              "code"=> "LI",
              "phone_code"=> "+423",
            ],
            [
              "name"=> "Lietuva",
              "code"=> "LT",
              "phone_code"=> "+370",
            ],
            [
              "name"=> "Luxembourg",
              "code"=> "LU",
              "phone_code"=> "+352",
            ],
            [
              "name"=> "澳門",
              "code"=> "MO",
              "phone_code"=> "+853",
            ],
            [
              "name"=> "Македонија",
              "code"=> "MK",
              "phone_code"=> "+389",
            ],
            [
              "name"=> "Madagasikara",
              "code"=> "MG",
              "phone_code"=> "+261",
            ],
            [
              "name"=> "Malawi",
              "code"=> "MW",
              "phone_code"=> "+265",
            ],
            [
              "name"=> "Malaysia",
              "code"=> "MY",
              "phone_code"=> "+60",
            ],
            [
              "name"=> "Maldives",
              "code"=> "MV",
              "phone_code"=> "+960",
            ],
            [
              "name"=> "Mali",
              "code"=> "ML",
              "phone_code"=> "+223",
            ],
            [
              "name"=> "Malta",
              "code"=> "MT",
              "phone_code"=> "+356",
            ],
            [
              "name"=> "M̧ajeļ",
              "code"=> "MH",
              "phone_code"=> "+692",
            ],
            [
              "name"=> "Martinique",
              "code"=> "MQ",
              "phone_code"=> "+596",
            ],
            [
              "name"=> "موريتانيا",
              "code"=> "MR",
              "phone_code"=> "+222",
            ],
            [
              "name"=> "Maurice",
              "code"=> "MU",
              "phone_code"=> "+230",
            ],
            [
              "name"=> "Mayotte",
              "code"=> "YT",
              "phone_code"=> "+262",
            ],
            [
              "name"=> "México",
              "code"=> "MX",
              "phone_code"=> "+52",
            ],
            [
              "name"=> "Micronesia",
              "code"=> "FM",
              "phone_code"=> "+691",
            ],
            [
              "name"=> "Moldova",
              "code"=> "MD",
              "phone_code"=> "+373",
            ],
            [
              "name"=> "Monaco",
              "code"=> "MC",
              "phone_code"=> "+377",
            ],
            [
              "name"=> "Монгол улс",
              "code"=> "MN",
              "phone_code"=> "+976",
            ],
            [
              "name"=> "Црна Гора",
              "code"=> "ME",
              "phone_code"=> "+382",
            ],
            [
              "name"=> "Montserrat",
              "code"=> "MS",
              "phone_code"=> "+1664",
            ],
            [
              "name"=> "المغرب",
              "code"=> "MA",
              "phone_code"=> "+212",
            ],
            [
              "name"=> "Moçambique",
              "code"=> "MZ",
              "phone_code"=> "+258",
            ],
            [
              "name"=> "Myanma",
              "code"=> "MM",
              "phone_code"=> "+95",
            ],
            [
              "name"=> "Namibia",
              "code"=> "NA",
              "phone_code"=> "+264",
            ],
            [
              "name"=> "Nauru",
              "code"=> "NR",
              "phone_code"=> "+674",
            ],
            [
              "name"=> "नपल",
              "code"=> "NP",
              "phone_code"=> "+977",
            ],
            [
              "name"=> "Nederland",
              "code"=> "NL",
              "phone_code"=> "+31",
            ],
            [
              "name"=> "Netherlands Antilles",
              "code"=> "AN",
              "phone_code"=> "+599",
            ],
            [
              "name"=> "Nouvelle-Calédonie",
              "code"=> "NC",
              "phone_code"=> "+687",
            ],
            [
              "name"=> "New Zealand",
              "code"=> "NZ",
              "phone_code"=> "+64",
            ],
            [
              "name"=> "Nicaragua",
              "code"=> "NI",
              "phone_code"=> "+505",
            ],
            [
              "name"=> "Niger",
              "code"=> "NE",
              "phone_code"=> "+227",
            ],
            [
              "name"=> "Nigeria",
              "code"=> "NG",
              "phone_code"=> "+234",
            ],
            [
              "name"=> "Niuē",
              "code"=> "NU",
              "phone_code"=> "+683",
            ],
            [
              "name"=> "Norfolk Island",
              "code"=> "NF",
              "phone_code"=> "+672",
            ],
            [
              "name"=> "Northern Mariana Islands",
              "code"=> "MP",
              "phone_code"=> "+1670",
            ],
            [
              "name"=> "Norge",
              "code"=> "NO",
              "phone_code"=> "+47",
            ],
            [
              "name"=> "عمان",
              "code"=> "OM",
              "phone_code"=> "+968",
            ],
            [
              "name"=> "Pakistan",
              "code"=> "PK",
              "phone_code"=> "+92",
            ],
            [
              "name"=> "Palau",
              "code"=> "PW",
              "phone_code"=> "+680",
            ],
            [
              "name"=> "فلسطين",
              "code"=> "PS",
              "phone_code"=> "+970",
            ],
            [
              "name"=> "Panamá",
              "code"=> "PA",
              "phone_code"=> "+507",
            ],
            [
              "name"=> "Papua Niugini",
              "code"=> "PG",
              "phone_code"=> "+675",
            ],
            [
              "name"=> "Paraguay",
              "code"=> "PY",
              "phone_code"=> "+595",
            ],
            [
              "name"=> "Perú",
              "code"=> "PE",
              "phone_code"=> "+51",
            ],
            [
              "name"=> "Pilipinas",
              "code"=> "PH",
              "phone_code"=> "+63",
            ],
            [
              "name"=> "Pitcairn Islands",
              "code"=> "PN",
              "phone_code"=> "+64",
            ],
            [
              "name"=> "Polska",
              "code"=> "PL",
              "phone_code"=> "+48",
            ],
            [
              "name"=> "Portugal",
              "code"=> "PT",
              "phone_code"=> "+351",
            ],
            [
              "name"=> "Puerto Rico",
              "code"=> "PR",
              "phone_code"=> "+1939",
            ],
            [
              "name"=> "Puerto Rico",
              "code"=> "PR",
              "phone_code"=> "+1787",
            ],
            [
              "name"=> "قطر",
              "code"=> "QA",
              "phone_code"=> "+974",
            ],
            [
              "name"=> "România",
              "code"=> "RO",
              "phone_code"=> "+40",
            ],
            [
              "name"=> "Россия",
              "code"=> "RU",
              "phone_code"=> "+7",
            ],
            [
              "name"=> "Rwanda",
              "code"=> "RW",
              "phone_code"=> "+250",
            ],
            [
              "name"=> "La Réunion",
              "code"=> "RE",
              "phone_code"=> "+262",
            ],
            [
              "name"=> "Saint-Barthélemy",
              "code"=> "BL",
              "phone_code"=> "+590",
            ],
            [
              "name"=> "Saint Helena",
              "code"=> "SH",
              "phone_code"=> "+290",
            ],
            [
              "name"=> "Saint Kitts and Nevis",
              "code"=> "KN",
              "phone_code"=> "+1869",
            ],
            [
              "name"=> "Saint Lucia",
              "code"=> "LC",
              "phone_code"=> "+1758",
            ],
            [
              "name"=> "Saint-Martin",
              "code"=> "MF",
              "phone_code"=> "+590",
            ],
            [
              "name"=> "Saint-Pierre-et-Miquelon",
              "code"=> "PM",
              "phone_code"=> "+508",
            ],
            [
              "name"=> "Saint Vincent and the Grenadines",
              "code"=> "VC",
              "phone_code"=> "+1784",
            ],
            [
              "name"=> "Samoa",
              "code"=> "WS",
              "phone_code"=> "+685",
            ],
            [
              "name"=> "San Marino",
              "code"=> "SM",
              "phone_code"=> "+378",
            ],
            [
              "name"=> "São Tomé e Príncipe",
              "code"=> "ST",
              "phone_code"=> "+239",
            ],
            [
              "name"=> "العربية السعودية",
              "code"=> "SA",
              "phone_code"=> "+966",
            ],
            [
              "name"=> "Sénégal",
              "code"=> "SN",
              "phone_code"=> "+221",
            ],
            [
              "name"=> "Србија",
              "code"=> "RS",
              "phone_code"=> "+381",
            ],
            [
              "name"=> "Seychelles",
              "code"=> "SC",
              "phone_code"=> "+248",
            ],
            [
              "name"=> "Sierra Leone",
              "code"=> "SL",
              "phone_code"=> "+232",
            ],
            [
              "name"=> "Singapore",
              "code"=> "SG",
              "phone_code"=> "+65",
            ],
            [
              "name"=> "Slovensko",
              "code"=> "SK",
              "phone_code"=> "+421",
            ],
            [
              "name"=> "Slovenija",
              "code"=> "SI",
              "phone_code"=> "+386",
            ],
            [
              "name"=> "Solomon Islands",
              "code"=> "SB",
              "phone_code"=> "+677",
            ],
            [
              "name"=> "Soomaaliya",
              "code"=> "SO",
              "phone_code"=> "+252",
            ],
            [
              "name"=> "South Africa",
              "code"=> "ZA",
              "phone_code"=> "+27",
            ],
            [
              "name"=> "South Sudan",
              "code"=> "SS",
              "phone_code"=> "+211",
            ],
            [
              "name"=> "South Georgia",
              "code"=> "GS",
              "phone_code"=> "+500",
            ],
            [
              "name"=> "España",
              "code"=> "ES",
              "phone_code"=> "+34",
            ],
            [
              "name"=> "Sri Lanka",
              "code"=> "LK",
              "phone_code"=> "+94",
            ],
            [
              "name"=> "السودان",
              "code"=> "SD",
              "phone_code"=> "+249",
            ],
            [
              "name"=> "Suriname",
              "code"=> "SR",
              "phone_code"=> "+597",
            ],
            [
              "name"=> "Svalbard og Jan Mayen",
              "code"=> "SJ",
              "phone_code"=> "+47",
            ],
            [
              "name"=> "Swaziland",
              "code"=> "SZ",
              "phone_code"=> "+268",
            ],
            [
              "name"=> "Sverige",
              "code"=> "SE",
              "phone_code"=> "+46",
            ],
            [
              "name"=> "Schweiz",
              "code"=> "CH",
              "phone_code"=> "+41",
            ],
            [
              "name"=> "سوريا",
              "code"=> "SY",
              "phone_code"=> "+963",
            ],
            [
              "name"=> "臺灣",
              "code"=> "TW",
              "phone_code"=> "+886",
            ],
            [
              "name"=> "Тоҷикистон",
              "code"=> "TJ",
              "phone_code"=> "+992",
            ],
            [
              "name"=> "Tanzania",
              "code"=> "TZ",
              "phone_code"=> "+255",
            ],
            [
              "name"=> "ประเทศไทย",
              "code"=> "TH",
              "phone_code"=> "+66",
            ],
            [
              "name"=> "Timor-Leste",
              "code"=> "TL",
              "phone_code"=> "+670",
            ],
            [
              "name"=> "Togo",
              "code"=> "TG",
              "phone_code"=> "+228",
            ],
            [
              "name"=> "Tokelau",
              "code"=> "TK",
              "phone_code"=> "+690",
            ],
            [
              "name"=> "Tonga",
              "code"=> "TO",
              "phone_code"=> "+676",
            ],
            [
              "name"=> "Trinidad and Tobago",
              "code"=> "TT",
              "phone_code"=> "+1868",
            ],
            [
              "name"=> "تونس",
              "code"=> "TN",
              "phone_code"=> "+216",
            ],
            [
              "name"=> "Türkiye",
              "code"=> "TR",
              "phone_code"=> "+90",
            ],
            [
              "name"=> "Türkmenistan",
              "code"=> "TM",
              "phone_code"=> "+993",
            ],
            [
              "name"=> "Turks and Caicos Islands",
              "code"=> "TC",
              "phone_code"=> "+1649",
            ],
            [
              "name"=> "Tuvalu",
              "code"=> "TV",
              "phone_code"=> "+688",
            ],
            [
              "name"=> "Uganda",
              "code"=> "UG",
              "phone_code"=> "+256",
            ],
            [
              "name"=> "Україна",
              "code"=> "UA",
              "phone_code"=> "+380",
            ],
            [
              "name"=> "دولة الإمارات العربية المتحدة",
              "code"=> "AE",
              "phone_code"=> "+971",
            ],
            [
              "name"=> "United Kingdom",
              "code"=> "GB",
              "phone_code"=> "+44",
            ],
            [
              "name"=> "United States",
              "code"=> "US",
              "phone_code"=> "+1",
            ],
            [
              "name"=> "Uruguay",
              "code"=> "UY",
              "phone_code"=> "+598",
            ],
            [
              "name"=> "Ozbekiston",
              "code"=> "UZ",
              "phone_code"=> "+998",
            ],
            [
              "name"=> "Vanuatu",
              "code"=> "VU",
              "phone_code"=> "+678",
            ],
            [
              "name"=> "Venezuela",
              "code"=> "VE",
              "phone_code"=> "+58",
            ],
            [
              "name"=> "Việt Nam",
              "code"=> "VN",
              "phone_code"=> "+84",
            ],
            [
              "name"=> "British Virgin Islands",
              "code"=> "VG",
              "phone_code"=> "+1284",
            ],
            [
              "name"=> "United States Virgin Islands",
              "code"=> "VI",
              "phone_code"=> "+1340",
            ],
            [
              "name"=> "Wallis et Futuna",
              "code"=> "WF",
              "phone_code"=> "+681",
            ],
            [
              "name"=> "اليَمَن",
              "code"=> "YE",
              "phone_code"=> "+967",
            ],
            [
              "name"=> "Zambia",
              "code"=> "ZM",
              "phone_code"=> "+260",
            ],
            [
              "name"=> "Zimbabwe",
              "code"=> "ZW",
              "phone_code"=> "+263",
            ],
        ];

        foreach ($entries as $entry) {
            Country::create($entry);
        }

    }
}
