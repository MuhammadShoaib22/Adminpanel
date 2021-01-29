<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();

        DB::insert("
        	INSERT INTO `countries` (`id`, `code`, `name`, `dial_code`, `currency_name`, `currency_symbol`, `currency_code`, `created_at`, `updated_at`) VALUES
			(1, 'AF', 'Afghanistan', 93, 'Afghan afghani', '؋', 'AFN', NOW(), NOW()),
			(2, 'AL', 'Albania', 355, 'Albanian lek', 'L', 'ALL', NOW(), NOW()),
			(3, 'DZ', 'Algeria', 213, 'Algerian dinar', 'د.ج', 'DZD', NOW(), NOW()),
			(4, 'AS', 'American Samoa', 1684, '', '', '', NOW(), NOW()),
			(5, 'AD', 'Andorra', 376, 'Euro', '€', 'EUR', NOW(), NOW()),
			(6, 'AO', 'Angola', 244, 'Angolan kwanza', 'Kz', 'AOA', NOW(), NOW()),
			(7, 'AI', 'Anguilla', 1264, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(8, 'AQ', 'Antarctica', 0, '', '', '', NOW(), NOW()),
			(9, 'AG', 'Antigua And Barbuda', 1268, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(10, 'AR', 'Argentina', 54, 'Argentine peso', '$', 'ARS', NOW(), NOW()),
			(11, 'AM', 'Armenia', 374, 'Armenian dram', '', 'AMD', NOW(), NOW()),
			(12, 'AW', 'Aruba', 297, 'Aruban florin', 'ƒ', 'AWG', NOW(), NOW()),
			(13, 'AU', 'Australia', 61, 'Australian dollar', '$', 'AUD', NOW(), NOW()),
			(14, 'AT', 'Austria', 43, 'Euro', '€', 'EUR', NOW(), NOW()),
			(15, 'AZ', 'Azerbaijan', 994, 'Azerbaijani manat', '', 'AZN', NOW(), NOW()),
			(16, 'BS', 'Bahamas The', 1242, '', '', '', NOW(), NOW()),
			(17, 'BH', 'Bahrain', 973, 'Bahraini dinar', '.د.ب', 'BHD', NOW(), NOW()),
			(18, 'BD', 'Bangladesh', 880, 'Bangladeshi taka', '৳', 'BDT', NOW(), NOW()),
			(19, 'BB', 'Barbados', 1246, 'Barbadian dollar', '$', 'BBD', NOW(), NOW()),
			(20, 'BY', 'Belarus', 375, 'Belarusian ruble', 'Br', 'BYR', NOW(), NOW()),
			(21, 'BE', 'Belgium', 32, 'Euro', '€', 'EUR', NOW(), NOW()),
			(22, 'BZ', 'Belize', 501, 'Belize dollar', '$', 'BZD', NOW(), NOW()),
			(23, 'BJ', 'Benin', 229, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(24, 'BM', 'Bermuda', 1441, 'Bermudian dollar', '$', 'BMD', NOW(), NOW()),
			(25, 'BT', 'Bhutan', 975, 'Bhutanese ngultrum', 'Nu.', 'BTN', NOW(), NOW()),
			(26, 'BO', 'Bolivia', 591, 'Bolivian boliviano', 'Bs.', 'BOB', NOW(), NOW()),
			(27, 'BA', 'Bosnia and Herzegovina', 387, 'Bosnia and Herzegovi', 'KM or КМ', 'BAM', NOW(), NOW()),
			(28, 'BW', 'Botswana', 267, 'Botswana pula', 'P', 'BWP', NOW(), NOW()),
			(29, 'BV', 'Bouvet Island', 0, '', '', '', NOW(), NOW()),
			(30, 'BR', 'Brazil', 55, 'Brazilian real', 'R$', 'BRL', NOW(), NOW()),
			(31, 'IO', 'British Indian Ocean Territory', 246, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(32, 'BN', 'Brunei', 673, 'Brunei dollar', '$', 'BND', NOW(), NOW()),
			(33, 'BG', 'Bulgaria', 359, 'Bulgarian lev', 'лв', 'BGN', NOW(), NOW()),
			(34, 'BF', 'Burkina Faso', 226, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(35, 'BI', 'Burundi', 257, 'Burundian franc', 'Fr', 'BIF', NOW(), NOW()),
			(36, 'KH', 'Cambodia', 855, 'Cambodian riel', '៛', 'KHR', NOW(), NOW()),
			(37, 'CM', 'Cameroon', 237, 'Central African CFA ', 'Fr', 'XAF', NOW(), NOW()),
			(38, 'CA', 'Canada', 1, 'Canadian dollar', '$', 'CAD', NOW(), NOW()),
			(39, 'CV', 'Cape Verde', 238, 'Cape Verdean escudo', 'Esc or $', 'CVE', NOW(), NOW()),
			(40, 'KY', 'Cayman Islands', 1345, 'Cayman Islands dolla', '$', 'KYD', NOW(), NOW()),
			(41, 'CF', 'Central African Republic', 236, 'Central African CFA ', 'Fr', 'XAF', NOW(), NOW()),
			(42, 'TD', 'Chad', 235, 'Central African CFA ', 'Fr', 'XAF', NOW(), NOW()),
			(43, 'CL', 'Chile', 56, 'Chilean peso', '$', 'CLP', NOW(), NOW()),
			(44, 'CN', 'China', 86, 'Chinese yuan', '¥ or 元', 'CNY', NOW(), NOW()),
			(45, 'CX', 'Christmas Island', 61, '', '', '', NOW(), NOW()),
			(46, 'CC', 'Cocos (Keeling) Islands', 672, 'Australian dollar', '$', 'AUD', NOW(), NOW()),
			(47, 'CO', 'Colombia', 57, 'Colombian peso', '$', 'COP', NOW(), NOW()),
			(48, 'KM', 'Comoros', 269, 'Comorian franc', 'Fr', 'KMF', NOW(), NOW()),
			(49, 'CG', 'Congo', 242, '', '', '', NOW(), NOW()),
			(50, 'CD', 'Congo The Democratic Republic Of The', 242, '', '', '', NOW(), NOW()),
			(51, 'CK', 'Cook Islands', 682, 'New Zealand dollar', '$', 'NZD', NOW(), NOW()),
			(52, 'CR', 'Costa Rica', 506, 'Costa Rican colón', '₡', 'CRC', NOW(), NOW()),
			(53, 'CI', 'Cote D''Ivoire (Ivory Coast)', 225, '', '', '', NOW(), NOW()),
			(54, 'HR', 'Croatia (Hrvatska)', 385, '', '', '', NOW(), NOW()),
			(55, 'CU', 'Cuba', 53, 'Cuban convertible pe', '$', 'CUC', NOW(), NOW()),
			(56, 'CY', 'Cyprus', 357, 'Euro', '€', 'EUR', NOW(), NOW()),
			(57, 'CZ', 'Czech Republic', 420, 'Czech koruna', 'Kč', 'CZK', NOW(), NOW()),
			(58, 'DK', 'Denmark', 45, 'Danish krone', 'kr', 'DKK', NOW(), NOW()),
			(59, 'DJ', 'Djibouti', 253, 'Djiboutian franc', 'Fr', 'DJF', NOW(), NOW()),
			(60, 'DM', 'Dominica', 1767, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(61, 'DO', 'Dominican Republic', 1809, 'Dominican peso', '$', 'DOP', NOW(), NOW()),
			(62, 'TP', 'East Timor', 670, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(63, 'EC', 'Ecuador', 593, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(64, 'EG', 'Egypt', 20, 'Egyptian pound', '£ or ج.م', 'EGP', NOW(), NOW()),
			(65, 'SV', 'El Salvador', 503, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(66, 'GQ', 'Equatorial Guinea', 240, 'Central African CFA ', 'Fr', 'XAF', NOW(), NOW()),
			(67, 'ER', 'Eritrea', 291, 'Eritrean nakfa', 'Nfk', 'ERN', NOW(), NOW()),
			(68, 'EE', 'Estonia', 372, 'Euro', '€', 'EUR', NOW(), NOW()),
			(69, 'ET', 'Ethiopia', 251, 'Ethiopian birr', 'Br', 'ETB', NOW(), NOW()),
			(70, 'XA', 'External Territories of Australia', 61, '', '', '', NOW(), NOW()),
			(71, 'FK', 'Falkland Islands', 500, 'Falkland Islands pou', '£', 'FKP', NOW(), NOW()),
			(72, 'FO', 'Faroe Islands', 298, 'Danish krone', 'kr', 'DKK', NOW(), NOW()),
			(73, 'FJ', 'Fiji Islands', 679, '', '', '', NOW(), NOW()),
			(74, 'FI', 'Finland', 358, 'Euro', '€', 'EUR', NOW(), NOW()),
			(75, 'FR', 'France', 33, 'Euro', '€', 'EUR', NOW(), NOW()),
			(76, 'GF', 'French Guiana', 594, '', '', '', NOW(), NOW()),
			(77, 'PF', 'French Polynesia', 689, 'CFP franc', 'Fr', 'XPF', NOW(), NOW()),
			(78, 'TF', 'French Southern Territories', 0, '', '', '', NOW(), NOW()),
			(79, 'GA', 'Gabon', 241, 'Central African CFA ', 'Fr', 'XAF', NOW(), NOW()),
			(80, 'GM', 'Gambia The', 220, '', '', '', NOW(), NOW()),
			(81, 'GE', 'Georgia', 995, 'Georgian lari', 'ლ', 'GEL', NOW(), NOW()),
			(82, 'DE', 'Germany', 49, 'Euro', '€', 'EUR', NOW(), NOW()),
			(83, 'GH', 'Ghana', 233, 'Ghana cedi', '₵', 'GHS', NOW(), NOW()),
			(84, 'GI', 'Gibraltar', 350, 'Gibraltar pound', '£', 'GIP', NOW(), NOW()),
			(85, 'GR', 'Greece', 30, 'Euro', '€', 'EUR', NOW(), NOW()),
			(86, 'GL', 'Greenland', 299, '', '', '', NOW(), NOW()),
			(87, 'GD', 'Grenada', 1473, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(88, 'GP', 'Guadeloupe', 590, '', '', '', NOW(), NOW()),
			(89, 'GU', 'Guam', 1671, '', '', '', NOW(), NOW()),
			(90, 'GT', 'Guatemala', 502, 'Guatemalan quetzal', 'Q', 'GTQ', NOW(), NOW()),
			(91, 'XU', 'Guernsey and Alderney', 44, '', '', '', NOW(), NOW()),
			(92, 'GN', 'Guinea', 224, 'Guinean franc', 'Fr', 'GNF', NOW(), NOW()),
			(93, 'GW', 'Guinea-Bissau', 245, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(94, 'GY', 'Guyana', 592, 'Guyanese dollar', '$', 'GYD', NOW(), NOW()),
			(95, 'HT', 'Haiti', 509, 'Haitian gourde', 'G', 'HTG', NOW(), NOW()),
			(96, 'HM', 'Heard and McDonald Islands', 0, '', '', '', NOW(), NOW()),
			(97, 'HN', 'Honduras', 504, 'Honduran lempira', 'L', 'HNL', NOW(), NOW()),
			(98, 'HK', 'Hong Kong S.A.R.', 852, '', '', '', NOW(), NOW()),
			(99, 'HU', 'Hungary', 36, 'Hungarian forint', 'Ft', 'HUF', NOW(), NOW()),
			(100, 'IS', 'Iceland', 354, 'Icelandic króna', 'kr', 'ISK', NOW(), NOW()),
			(101, 'IN', 'India', 91, 'Indian rupee', '₹', 'INR', NOW(), NOW()),
			(102, 'ID', 'Indonesia', 62, 'Indonesian rupiah', 'Rp', 'IDR', NOW(), NOW()),
			(103, 'IR', 'Iran', 98, 'Iranian rial', '﷼', 'IRR', NOW(), NOW()),
			(104, 'IQ', 'Iraq', 964, 'Iraqi dinar', 'ع.د', 'IQD', NOW(), NOW()),
			(105, 'IE', 'Ireland', 353, 'Euro', '€', 'EUR', NOW(), NOW()),
			(106, 'IL', 'Israel', 972, 'Israeli new shekel', '₪', 'ILS', NOW(), NOW()),
			(107, 'IT', 'Italy', 39, 'Euro', '€', 'EUR', NOW(), NOW()),
			(108, 'JM', 'Jamaica', 1876, 'Jamaican dollar', '$', 'JMD', NOW(), NOW()),
			(109, 'JP', 'Japan', 81, 'Japanese yen', '¥', 'JPY', NOW(), NOW()),
			(110, 'XJ', 'Jersey', 44, 'British pound', '£', 'GBP', NOW(), NOW()),
			(111, 'JO', 'Jordan', 962, 'Jordanian dinar', 'د.ا', 'JOD', NOW(), NOW()),
			(112, 'KZ', 'Kazakhstan', 7, 'Kazakhstani tenge', '', 'KZT', NOW(), NOW()),
			(113, 'KE', 'Kenya', 254, 'Kenyan shilling', 'Sh', 'KES', NOW(), NOW()),
			(114, 'KI', 'Kiribati', 686, 'Australian dollar', '$', 'AUD', NOW(), NOW()),
			(115, 'KP', 'Korea North', 850, '', '', '', NOW(), NOW()),
			(116, 'KR', 'Korea South', 82, '', '', '', NOW(), NOW()),
			(117, 'KW', 'Kuwait', 965, 'Kuwaiti dinar', 'د.ك', 'KWD', NOW(), NOW()),
			(118, 'KG', 'Kyrgyzstan', 996, 'Kyrgyzstani som', 'лв', 'KGS', NOW(), NOW()),
			(119, 'LA', 'Laos', 856, 'Lao kip', '₭', 'LAK', NOW(), NOW()),
			(120, 'LV', 'Latvia', 371, 'Euro', '€', 'EUR', NOW(), NOW()),
			(121, 'LB', 'Lebanon', 961, 'Lebanese pound', 'ل.ل', 'LBP', NOW(), NOW()),
			(122, 'LS', 'Lesotho', 266, 'Lesotho loti', 'L', 'LSL', NOW(), NOW()),
			(123, 'LR', 'Liberia', 231, 'Liberian dollar', '$', 'LRD', NOW(), NOW()),
			(124, 'LY', 'Libya', 218, 'Libyan dinar', 'ل.د', 'LYD', NOW(), NOW()),
			(125, 'LI', 'Liechtenstein', 423, 'Swiss franc', 'Fr', 'CHF', NOW(), NOW()),
			(126, 'LT', 'Lithuania', 370, 'Euro', '€', 'EUR', NOW(), NOW()),
			(127, 'LU', 'Luxembourg', 352, 'Euro', '€', 'EUR', NOW(), NOW()),
			(128, 'MO', 'Macau S.A.R.', 853, '', '', '', NOW(), NOW()),
			(129, 'MK', 'Macedonia', 389, '', '', '', NOW(), NOW()),
			(130, 'MG', 'Madagascar', 261, 'Malagasy ariary', 'Ar', 'MGA', NOW(), NOW()),
			(131, 'MW', 'Malawi', 265, 'Malawian kwacha', 'MK', 'MWK', NOW(), NOW()),
			(132, 'MY', 'Malaysia', 60, 'Malaysian ringgit', 'RM', 'MYR', NOW(), NOW()),
			(133, 'MV', 'Maldives', 960, 'Maldivian rufiyaa', '.ރ', 'MVR', NOW(), NOW()),
			(134, 'ML', 'Mali', 223, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(135, 'MT', 'Malta', 356, 'Euro', '€', 'EUR', NOW(), NOW()),
			(136, 'XM', 'Man (Isle of)', 44, '', '', '', NOW(), NOW()),
			(137, 'MH', 'Marshall Islands', 692, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(138, 'MQ', 'Martinique', 596, '', '', '', NOW(), NOW()),
			(139, 'MR', 'Mauritania', 222, 'Mauritanian ouguiya', 'UM', 'MRO', NOW(), NOW()),
			(140, 'MU', 'Mauritius', 230, 'Mauritian rupee', '₨', 'MUR', NOW(), NOW()),
			(141, 'YT', 'Mayotte', 269, '', '', '', NOW(), NOW()),
			(142, 'MX', 'Mexico', 52, 'Mexican peso', '$', 'MXN', NOW(), NOW()),
			(143, 'FM', 'Micronesia', 691, 'Micronesian dollar', '$', '', NOW(), NOW()),
			(144, 'MD', 'Moldova', 373, 'Moldovan leu', 'L', 'MDL', NOW(), NOW()),
			(145, 'MC', 'Monaco', 377, 'Euro', '€', 'EUR', NOW(), NOW()),
			(146, 'MN', 'Mongolia', 976, 'Mongolian tögrög', '₮', 'MNT', NOW(), NOW()),
			(147, 'MS', 'Montserrat', 1664, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(148, 'MA', 'Morocco', 212, 'Moroccan dirham', 'د.م.', 'MAD', NOW(), NOW()),
			(149, 'MZ', 'Mozambique', 258, 'Mozambican metical', 'MT', 'MZN', NOW(), NOW()),
			(150, 'MM', 'Myanmar', 95, 'Burmese kyat', 'Ks', 'MMK', NOW(), NOW()),
			(151, 'NA', 'Namibia', 264, 'Namibian dollar', '$', 'NAD', NOW(), NOW()),
			(152, 'NR', 'Nauru', 674, 'Australian dollar', '$', 'AUD', NOW(), NOW()),
			(153, 'NP', 'Nepal', 977, 'Nepalese rupee', '₨', 'NPR', NOW(), NOW()),
			(154, 'AN', 'Netherlands Antilles', 599, '', '', '', NOW(), NOW()),
			(155, 'NL', 'Netherlands The', 31, '', '', '', NOW(), NOW()),
			(156, 'NC', 'New Caledonia', 687, 'CFP franc', 'Fr', 'XPF', NOW(), NOW()),
			(157, 'NZ', 'New Zealand', 64, 'New Zealand dollar', '$', 'NZD', NOW(), NOW()),
			(158, 'NI', 'Nicaragua', 505, 'Nicaraguan córdoba', 'C$', 'NIO', NOW(), NOW()),
			(159, 'NE', 'Niger', 227, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(160, 'NG', 'Nigeria', 234, 'Nigerian naira', '₦', 'NGN', NOW(), NOW()),
			(161, 'NU', 'Niue', 683, 'New Zealand dollar', '$', 'NZD', NOW(), NOW()),
			(162, 'NF', 'Norfolk Island', 672, '', '', '', NOW(), NOW()),
			(163, 'MP', 'Northern Mariana Islands', 1670, '', '', '', NOW(), NOW()),
			(164, 'NO', 'Norway', 47, 'Norwegian krone', 'kr', 'NOK', NOW(), NOW()),
			(165, 'OM', 'Oman', 968, 'Omani rial', 'ر.ع.', 'OMR', NOW(), NOW()),
			(166, 'PK', 'Pakistan', 92, 'Pakistani rupee', '₨', 'PKR', NOW(), NOW()),
			(167, 'PW', 'Palau', 680, 'Palauan dollar', '$', '', NOW(), NOW()),
			(168, 'PS', 'Palestinian Territory Occupied', 970, '', '', '', NOW(), NOW()),
			(169, 'PA', 'Panama', 507, 'Panamanian balboa', 'B/.', 'PAB', NOW(), NOW()),
			(170, 'PG', 'Papua new Guinea', 675, 'Papua New Guinean ki', 'K', 'PGK', NOW(), NOW()),
			(171, 'PY', 'Paraguay', 595, 'Paraguayan guaraní', '₲', 'PYG', NOW(), NOW()),
			(172, 'PE', 'Peru', 51, 'Peruvian nuevo sol', 'S/.', 'PEN', NOW(), NOW()),
			(173, 'PH', 'Philippines', 63, 'Philippine peso', '₱', 'PHP', NOW(), NOW()),
			(174, 'PN', 'Pitcairn Island', 0, '', '', '', NOW(), NOW()),
			(175, 'PL', 'Poland', 48, 'Polish złoty', 'zł', 'PLN', NOW(), NOW()),
			(176, 'PT', 'Portugal', 351, 'Euro', '€', 'EUR', NOW(), NOW()),
			(177, 'PR', 'Puerto Rico', 1787, '', '', '', NOW(), NOW()),
			(178, 'QA', 'Qatar', 974, 'Qatari riyal', 'ر.ق', 'QAR', NOW(), NOW()),
			(179, 'RE', 'Reunion', 262, '', '', '', NOW(), NOW()),
			(180, 'RO', 'Romania', 40, 'Romanian leu', 'lei', 'RON', NOW(), NOW()),
			(181, 'RU', 'Russia', 70, 'Russian ruble', '', 'RUB', NOW(), NOW()),
			(182, 'RW', 'Rwanda', 250, 'Rwandan franc', 'Fr', 'RWF', NOW(), NOW()),
			(183, 'SH', 'Saint Helena', 290, 'Saint Helena pound', '£', 'SHP', NOW(), NOW()),
			(184, 'KN', 'Saint Kitts And Nevis', 1869, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(185, 'LC', 'Saint Lucia', 1758, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(186, 'PM', 'Saint Pierre and Miquelon', 508, '', '', '', NOW(), NOW()),
			(187, 'VC', 'Saint Vincent And The Grenadines', 1784, 'East Caribbean dolla', '$', 'XCD', NOW(), NOW()),
			(188, 'WS', 'Samoa', 684, 'Samoan tālā', 'T', 'WST', NOW(), NOW()),
			(189, 'SM', 'San Marino', 378, 'Euro', '€', 'EUR', NOW(), NOW()),
			(190, 'ST', 'Sao Tome and Principe', 239, 'São Tomé and Príncip', 'Db', 'STD', NOW(), NOW()),
			(191, 'SA', 'Saudi Arabia', 966, 'Saudi riyal', 'ر.س', 'SAR', NOW(), NOW()),
			(192, 'SN', 'Senegal', 221, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(193, 'RS', 'Serbia', 381, 'Serbian dinar', 'дин. or din.', 'RSD', NOW(), NOW()),
			(194, 'SC', 'Seychelles', 248, 'Seychellois rupee', '₨', 'SCR', NOW(), NOW()),
			(195, 'SL', 'Sierra Leone', 232, 'Sierra Leonean leone', 'Le', 'SLL', NOW(), NOW()),
			(196, 'SG', 'Singapore', 65, 'Brunei dollar', '$', 'BND', NOW(), NOW()),
			(197, 'SK', 'Slovakia', 421, 'Euro', '€', 'EUR', NOW(), NOW()),
			(198, 'SI', 'Slovenia', 386, 'Euro', '€', 'EUR', NOW(), NOW()),
			(199, 'XG', 'Smaller Territories of the UK', 44, '', '', '', NOW(), NOW()),
			(200, 'SB', 'Solomon Islands', 677, 'Solomon Islands doll', '$', 'SBD', NOW(), NOW()),
			(201, 'SO', 'Somalia', 252, 'Somali shilling', 'Sh', 'SOS', NOW(), NOW()),
			(202, 'ZA', 'South Africa', 27, 'South African rand', 'R', 'ZAR', NOW(), NOW()),
			(203, 'GS', 'South Georgia', 0, '', '', '', NOW(), NOW()),
			(204, 'SS', 'South Sudan', 211, 'South Sudanese pound', '£', 'SSP', NOW(), NOW()),
			(205, 'ES', 'Spain', 34, 'Euro', '€', 'EUR', NOW(), NOW()),
			(206, 'LK', 'Sri Lanka', 94, 'Sri Lankan rupee', 'Rs or රු', 'LKR', NOW(), NOW()),
			(207, 'SD', 'Sudan', 249, 'Sudanese pound', 'ج.س.', 'SDG', NOW(), NOW()),
			(208, 'SR', 'Suriname', 597, 'Surinamese dollar', '$', 'SRD', NOW(), NOW()),
			(209, 'SJ', 'Svalbard And Jan Mayen Islands', 47, '', '', '', NOW(), NOW()),
			(210, 'SZ', 'Swaziland', 268, 'Swazi lilangeni', 'L', 'SZL', NOW(), NOW()),
			(211, 'SE', 'Sweden', 46, 'Swedish krona', 'kr', 'SEK', NOW(), NOW()),
			(212, 'CH', 'Switzerland', 41, 'Swiss franc', 'Fr', 'CHF', NOW(), NOW()),
			(213, 'SY', 'Syria', 963, 'Syrian pound', '£ or ل.س', 'SYP', NOW(), NOW()),
			(214, 'TW', 'Taiwan', 886, 'New Taiwan dollar', '$', 'TWD', NOW(), NOW()),
			(215, 'TJ', 'Tajikistan', 992, 'Tajikistani somoni', 'ЅМ', 'TJS', NOW(), NOW()),
			(216, 'TZ', 'Tanzania', 255, 'Tanzanian shilling', 'Sh', 'TZS', NOW(), NOW()),
			(217, 'TH', 'Thailand', 66, 'Thai baht', '฿', 'THB', NOW(), NOW()),
			(218, 'TG', 'Togo', 228, 'West African CFA fra', 'Fr', 'XOF', NOW(), NOW()),
			(219, 'TK', 'Tokelau', 690, '', '', '', NOW(), NOW()),
			(220, 'TO', 'Tonga', 676, 'Tongan paʻanga', 'T$', 'TOP', NOW(), NOW()),
			(221, 'TT', 'Trinidad And Tobago', 1868, 'Trinidad and Tobago ', '$', 'TTD', NOW(), NOW()),
			(222, 'TN', 'Tunisia', 216, 'Tunisian dinar', 'د.ت', 'TND', NOW(), NOW()),
			(223, 'TR', 'Turkey', 90, 'Turkish lira', '', 'TRY', NOW(), NOW()),
			(224, 'TM', 'Turkmenistan', 7370, 'Turkmenistan manat', 'm', 'TMT', NOW(), NOW()),
			(225, 'TC', 'Turks And Caicos Islands', 1649, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(226, 'TV', 'Tuvalu', 688, 'Australian dollar', '$', 'AUD', NOW(), NOW()),
			(227, 'UG', 'Uganda', 256, 'Ugandan shilling', 'Sh', 'UGX', NOW(), NOW()),
			(228, 'UA', 'Ukraine', 380, 'Ukrainian hryvnia', '₴', 'UAH', NOW(), NOW()),
			(229, 'AE', 'United Arab Emirates', 971, 'United Arab Emirates', 'د.إ', 'AED', NOW(), NOW()),
			(230, 'GB', 'United Kingdom', 44, 'British pound', '£', 'GBP', NOW(), NOW()),
			(231, 'US', 'United States', 1, 'United States dollar', '$', 'USD', NOW(), NOW()),
			(232, 'UM', 'United States Minor Outlying Islands', 1, '', '', '', NOW(), NOW()),
			(233, 'UY', 'Uruguay', 598, 'Uruguayan peso', '$', 'UYU', NOW(), NOW()),
			(234, 'UZ', 'Uzbekistan', 998, 'Uzbekistani som', '', 'UZS', NOW(), NOW()),
			(235, 'VU', 'Vanuatu', 678, 'Vanuatu vatu', 'Vt', 'VUV', NOW(), NOW()),
			(236, 'VA', 'Vatican City State (Holy See)', 39, '', '', '', NOW(), NOW()),
			(237, 'VE', 'Venezuela', 58, 'Venezuelan bolívar', 'Bs F', 'VEF', NOW(), NOW()),
			(238, 'VN', 'Vietnam', 84, 'Vietnamese đồng', '₫', 'VND', NOW(), NOW()),
			(239, 'VG', 'Virgin Islands (British)', 1284, '', '', '', NOW(), NOW()),
			(240, 'VI', 'Virgin Islands (US)', 1340, '', '', '', NOW(), NOW()),
			(241, 'WF', 'Wallis And Futuna Islands', 681, '', '', '', NOW(), NOW()),
			(242, 'EH', 'Western Sahara', 212, '', '', '', NOW(), NOW()),
			(243, 'YE', 'Yemen', 967, 'Yemeni rial', '﷼', 'YER', NOW(), NOW()),
			(244, 'YU', 'Yugoslavia', 38, '', '', '', NOW(), NOW()),
			(245, 'ZM', 'Zambia', 260, 'Zambian kwacha', 'ZK', 'ZMW', NOW(), NOW()),
			(246, 'ZW', 'Zimbabwe', 263, 'Botswana pula', 'P', 'BWP', NOW(), NOW())
            ");
            
    }
}
