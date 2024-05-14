<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Double Child Row Table</title>
</head>

<body>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Operator</th>
                <th>Total</th>
            </tr>
        </thead>
    </table>

    <script>
        var data = {
            "pemasukan": {
                "penerimaan dari penjualan tunai": {
                    "081295595758": {
                        "total": "215805",
                        "transaksi": [{
                                "no_invoice": "ZK-S-40811",
                                "jumlah": "128010",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40780",
                                "keterangan": "17000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40777",
                                "keterangan": "10795"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40813",
                                "keterangan": "60000"
                            }
                        ]
                    },
                    "081392031837": {
                        "total": "164050",
                        "transaksi": [{
                                "no_invoice": "ZK-S-40869",
                                "jumlah": "7225",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40868",
                                "keterangan": "62500"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40830",
                                "keterangan": "17000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40832",
                                "keterangan": "12325"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40834",
                                "keterangan": "65000"
                            }
                        ]
                    },
                    "082265069112": {
                        "total": "2365000",
                        "transaksi": [{
                                "no_invoice": "MTSC-S-40829",
                                "jumlah": "135000",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40752",
                                "keterangan": "1135000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40849",
                                "keterangan": "1095000"
                            }
                        ]
                    },
                    "082316665757": {
                        "total": "413585",
                        "transaksi": [{
                                "no_invoice": "ZS-S-40886",
                                "jumlah": "34000",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZS-S-40768",
                                "keterangan": "80000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZS-S-40872",
                                "keterangan": "82000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZS-S-40766",
                                "keterangan": "15725"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZS-S-40851",
                                "keterangan": "61710"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZS-S-40894",
                                "keterangan": "16150"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZS-S-40789",
                                "keterangan": "124000"
                            }
                        ]
                    },
                    "082323665556": {
                        "total": "330020",
                        "transaksi": [{
                                "no_invoice": "ZP-S-40839",
                                "jumlah": "17340",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40838",
                                "keterangan": "16320"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40797",
                                "keterangan": "17425"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40893",
                                "keterangan": "16320"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40891",
                                "keterangan": "15300"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40755",
                                "keterangan": "14025"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40892",
                                "keterangan": "14025"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40890",
                                "keterangan": "20400"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40767",
                                "keterangan": "14875"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40771",
                                "keterangan": "70125"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40782",
                                "keterangan": "39865"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40784",
                                "keterangan": "34000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40783",
                                "keterangan": "40000"
                            }
                        ]
                    },
                    "082323665557": {
                        "total": "308890",
                        "transaksi": [{
                                "no_invoice": "ZD-S-40798",
                                "jumlah": "6800",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40786",
                                "keterangan": "10200"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40824",
                                "keterangan": "8500"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40763",
                                "keterangan": "7225"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40841",
                                "keterangan": "8500"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40760",
                                "keterangan": "35000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40759",
                                "keterangan": "59840"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40764",
                                "keterangan": "17000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40765",
                                "keterangan": "40000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40794",
                                "keterangan": "3825"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40800",
                                "keterangan": "27000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZD-S-40795",
                                "keterangan": "85000"
                            }
                        ]
                    },
                    "082324948999": {
                        "total": "360445",
                        "transaksi": [{
                                "no_invoice": "ZB-S-40876",
                                "jumlah": "28050",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40880",
                                "keterangan": "7650"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40879",
                                "keterangan": "15300"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40875",
                                "keterangan": "9095"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40878",
                                "keterangan": "108000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40856",
                                "keterangan": "33150"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40889",
                                "keterangan": "27200"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40861",
                                "keterangan": "14875"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40770",
                                "keterangan": "16575"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40804",
                                "keterangan": "6375"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40820",
                                "keterangan": "3400"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40761",
                                "keterangan": "16575"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40803",
                                "keterangan": "34000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40762",
                                "keterangan": "6500"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40881",
                                "keterangan": "23500"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40826",
                                "keterangan": "10200"
                            }
                        ]
                    },
                    "085200000839": {
                        "total": "98750",
                        "transaksi": [{
                                "no_invoice": "ZB-S-40836",
                                "jumlah": "35000",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40848",
                                "keterangan": "17425"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40837",
                                "keterangan": "9775"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40840",
                                "keterangan": "36550"
                            }
                        ]
                    },
                    "085233445959": {
                        "total": "81515",
                        "transaksi": [{
                                "no_invoice": "ZB-S-40870",
                                "jumlah": "17000",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40793",
                                "keterangan": "28050"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40790",
                                "keterangan": "17000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZB-S-40871",
                                "keterangan": "19465"
                            }
                        ]
                    },
                    "085877033112": {
                        "total": "3105000",
                        "transaksi": [{
                                "no_invoice": "MTSC-S-40769",
                                "jumlah": "200000",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40863",
                                "keterangan": "570000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40812",
                                "keterangan": "255000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40749",
                                "keterangan": "310000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40778",
                                "keterangan": "230000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40898",
                                "keterangan": "1130000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40809",
                                "keterangan": "360000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "MTSC-S-40842",
                                "keterangan": "50000"
                            }
                        ]
                    },
                    "087733440555": {
                        "total": "133195",
                        "transaksi": [{
                                "no_invoice": "ZW-S-40835",
                                "jumlah": "76500",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZW-S-40887",
                                "keterangan": "11900"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZW-S-40885",
                                "keterangan": "6545"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZW-S-40884",
                                "keterangan": "15300"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZW-S-40883",
                                "keterangan": "22950"
                            }
                        ]
                    },
                    "087733585557": {
                        "total": "235110",
                        "transaksi": [{
                                "no_invoice": "ZK-S-40865",
                                "jumlah": "49300",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40866",
                                "keterangan": "2125"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZK-S-40833",
                                "keterangan": "183685"
                            }
                        ]
                    },
                    "6281295595758": {
                        "total": "234405",
                        "transaksi": [{
                                "no_invoice": "ZP-S-40823",
                                "jumlah": "22000",
                                "keterangan": "-"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40867",
                                "keterangan": "27200"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40753",
                                "keterangan": "27455"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40806",
                                "keterangan": "60000"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40827",
                                "keterangan": "23375"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40802",
                                "keterangan": "8500"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40825",
                                "keterangan": "9775"
                            },
                            {
                                "no_invoice": "",
                                "jumlah": "ZP-S-40874",
                                "keterangan": "56100"
                            }
                        ]
                    }
                },
                "penerimaan dari penjualan tempo / dp": {
                    "081295595758": {
                        "total": "1000000",
                        "transaksi": [{
                            "no_invoice": "3-KWM15-P170523",
                            "jumlah": "1000000",
                            "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                        }]
                    },
                    "082316665757": {
                        "total": "610000",
                        "transaksi": [{
                                "no_invoice": "6-SRM15-P180523",
                                "jumlah": "100000",
                                "keterangan": "Jam acara : 15:00, Waktu Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "1-SRM15-P180523",
                                "jumlah": "510000",
                                "keterangan": "Jam acara : , Waktu Pengiriman : Pagi "
                            }
                        ]
                    },
                    "082323665557": {
                        "total": "2100000",
                        "transaksi": [{
                                "no_invoice": "6-DRM15-P180523",
                                "jumlah": "400000",
                                "keterangan": "Jam Acara : 17:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "5-DRM15-P190523",
                                "jumlah": "200000",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "2-DRM15-P180523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : 16:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "3-DRM15-P170523",
                                "jumlah": "500000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            }
                        ]
                    },
                    "082324948999": {
                        "total": "2870000",
                        "transaksi": [{
                                "no_invoice": "4-BWM15-P170523",
                                "jumlah": "1040000",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "1-BWM15-P180523",
                                "jumlah": "400000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "3-BWM15-P160523",
                                "jumlah": "1430000",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Sore "
                            }
                        ]
                    },
                    "085233445959": {
                        "total": "590000",
                        "transaksi": [{
                                "no_invoice": "4-BPM15-P160523",
                                "jumlah": "90000",
                                "keterangan": "Jam Acara : 17:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "6-BPM15-P170523",
                                "jumlah": "500000",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Pagi "
                            }
                        ]
                    },
                    "087733440555": {
                        "total": "2300000",
                        "transaksi": [{
                                "no_invoice": "4-WLM15-P170523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : , Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "1-WLM15-P210523",
                                "jumlah": "300000",
                                "keterangan": "Jam Acara : , Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "5-WLM15-P180523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : 08:00, Jenis Pengiriman : Sore "
                            }
                        ]
                    },
                    "087733585557": {
                        "total": "7960000",
                        "transaksi": [{
                                "no_invoice": "14-KJM15-P170523",
                                "jumlah": "1860000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "1-KJM15-P180523",
                                "jumlah": "675000",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "4-KJM15-P160523",
                                "jumlah": "60000",
                                "keterangan": "Jam Acara : 10:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "15-KJM15-P180523",
                                "jumlah": "550000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "2-KJM15-P160523",
                                "jumlah": "150000",
                                "keterangan": "Jam Acara : 09:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "12-KJM15-P180523",
                                "jumlah": "455000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "11-KJM15-P190523",
                                "jumlah": "150000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "10-KJM15-P170523",
                                "jumlah": "90000",
                                "keterangan": "Jam Acara : 08:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "3-KJM15-P170523",
                                "jumlah": "1040000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "8-KJM15-P170523",
                                "jumlah": "800000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "5-KJM15-P180523",
                                "jumlah": "2000000",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "9-KJM15-P180523",
                                "jumlah": "130000",
                                "keterangan": "Jam Acara : 07:00, Jenis Pengiriman : Sore "
                            }
                        ]
                    },
                    "6281295595758": {
                        "total": "240000",
                        "transaksi": [{
                            "no_invoice": "1-PRM15-P180523",
                            "jumlah": "240000",
                            "keterangan": "Jam Acara : 14:00, Jenis Pengiriman : Pagi "
                        }]
                    }
                }
            },
            "totalPemasukan": 25715770,
            "pengeluaran": {
                "Bahan Bakar": {
                    "081295595758": {
                        "total": "1000000",
                        "transaksi": [{
                                "no_invoice": "3-KWM15-P170523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "3-KWM15-P170523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 11:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "1-KWM15-P190523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            }
                        ]
                    },
                    "081392031837": {
                        "total": "0",
                        "transaksi": [{
                                "no_invoice": "2-KDM15-P180523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 14:00, Waktu Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "3-KDM15-P150523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 20:00, Waktu Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "1-KDM15-P170523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 14:00, Waktu Pengiriman : Pagi "
                            }
                        ]
                    },
                    "082316665757": {
                        "total": "610000",
                        "transaksi": [{
                                "no_invoice": "1-SRM15-P180523",
                                "jumlah": "510000",
                                "keterangan": "Jam acara : , Waktu Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "3-SRM15-P190523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 19:43, Waktu Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "4-SRM15-P200523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 01:45, Waktu Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "5-SRM15-P190523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 08:00, Waktu Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "2-SRM15-P200523",
                                "jumlah": "0",
                                "keterangan": "Jam acara : 19:22, Waktu Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "6-SRM15-P180523",
                                "jumlah": "100000",
                                "keterangan": "Jam acara : 15:00, Waktu Pengiriman : Pagi "
                            }
                        ]
                    },
                    "082323665557": {
                        "total": "2100000",
                        "transaksi": [{
                                "no_invoice": "5-DRM15-P190523",
                                "jumlah": "200000",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "6-DRM15-P180523",
                                "jumlah": "400000",
                                "keterangan": "Jam Acara : 17:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "2-DRM15-P180523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : 16:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "4-DRM15-P200523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 09:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "3-DRM15-P170523",
                                "jumlah": "500000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "1-DRM15-P170523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 13:00, Jenis Pengiriman : Pagi "
                            }
                        ]
                    },
                    "082324948999": {
                        "total": "2870000",
                        "transaksi": [{
                                "no_invoice": "1-BWM15-P180523",
                                "jumlah": "400000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "4-BWM15-P170523",
                                "jumlah": "1040000",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "5-BWM15-P160523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "6-BWM15-P160523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "3-BWM15-P160523",
                                "jumlah": "1430000",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "2-BWM15-P150523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Sore "
                            }
                        ]
                    },
                    "085233445959": {
                        "total": "590000",
                        "transaksi": [{
                                "no_invoice": "2-BPM15-P180523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "6-BPM15-P170523",
                                "jumlah": "500000",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "5-BPM15-P150523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 17:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "3-BPM15-P160523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 17:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "4-BPM15-P160523",
                                "jumlah": "90000",
                                "keterangan": "Jam Acara : 17:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "1-BPM15-P160523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 10:00, Jenis Pengiriman : Pagi "
                            }
                        ]
                    },
                    "087733440555": {
                        "total": "2300000",
                        "transaksi": [{
                                "no_invoice": "5-WLM15-P180523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : 08:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "2-WLM15-P240523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : , Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "1-WLM15-P210523",
                                "jumlah": "300000",
                                "keterangan": "Jam Acara : , Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "6-WLM15-P270523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 18:47, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "4-WLM15-P170523",
                                "jumlah": "1000000",
                                "keterangan": "Jam Acara : , Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "7-WLM15-P200523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 12:08, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "3-WLM15-P240523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : , Jenis Pengiriman : Sore "
                            }
                        ]
                    },
                    "087733585557": {
                        "total": "7960000",
                        "transaksi": [{
                                "no_invoice": "15-KJM15-P180523",
                                "jumlah": "550000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "14-KJM15-P170523",
                                "jumlah": "1860000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "1-KJM15-P180523",
                                "jumlah": "675000",
                                "keterangan": "Jam Acara : 19:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "2-KJM15-P160523",
                                "jumlah": "150000",
                                "keterangan": "Jam Acara : 09:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "13-KJM15-P200523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "5-KJM15-P180523",
                                "jumlah": "2000000",
                                "keterangan": "Jam Acara : 12:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "6-KJM15-P180523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 14:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "7-KJM15-P210523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 07:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "8-KJM15-P170523",
                                "jumlah": "800000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "4-KJM15-P160523",
                                "jumlah": "60000",
                                "keterangan": "Jam Acara : 10:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "9-KJM15-P180523",
                                "jumlah": "130000",
                                "keterangan": "Jam Acara : 07:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "3-KJM15-P170523",
                                "jumlah": "1040000",
                                "keterangan": "Jam Acara : 18:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "10-KJM15-P170523",
                                "jumlah": "90000",
                                "keterangan": "Jam Acara : 08:00, Jenis Pengiriman : Sore "
                            },
                            {
                                "no_invoice": "11-KJM15-P190523",
                                "jumlah": "150000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "12-KJM15-P180523",
                                "jumlah": "455000",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            },
                            {
                                "no_invoice": "16-KJM15-P170523",
                                "jumlah": "0",
                                "keterangan": "Jam Acara : 15:00, Jenis Pengiriman : Pagi "
                            }
                        ]
                    },
                    "6281295595758": {
                        "total": "240000",
                        "transaksi": [{
                            "no_invoice": "1-PRM15-P180523",
                            "jumlah": "240000",
                            "keterangan": "Jam Acara : 14:00, Jenis Pengiriman : Pagi "
                        }]
                    }
                }
            },
            "totalPengeluaran": 17670000
        }


        $(document).ready(function() {
            var table = $('#example').DataTable({
                "data": transformData(data.pemasukan),
                "columns": [{
                        "title": "Kategori",
                        "data": "kategori"
                    },
                    {
                        "title": "Operator",
                        "data": "operator"
                    },
                    {
                        "title": "Total",
                        "data": "total"
                    }
                ],
                "paging": false,
                "info": false
            });

            $('#example tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });

        function transformData(data) {
            var transformed = [];
            for (var kategori in data) {
                for (var operator in data[kategori]) {
                    var item = data[kategori][operator];
                    transformed.push({
                        "kategori": kategori,
                        "operator": operator,
                        "total": item.total,
                        "transaksi": item.transaksi
                    });
                }
            }
            return transformed;
        }

        function format(d) {
            var html = `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">`;
            html += `<tr><th>No. Invoice</th><th>Jumlah</th><th>Keterangan</th></tr>`;
            d.transaksi.forEach(tx => {
                html += `<tr><td>${tx.no_invoice}</td><td>${tx.jumlah}</td><td>${tx.keterangan}</td></tr>`;
            });
            html += `</table>`;
            return html;
        }
    </script>
</body>

</html>