// GRAPH pour la trésorerie

// highcharts graph
Highcharts.chart('tresorerie_graph', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tresorerie'
    },
    subtitle: {
        text: 'Source: <a href="https://www.data.gouv.fr/fr/datasets/finances-publiques-departementales/">data.gouv.fr</a>'
    },
    xAxis: {
        // ici chopper les noms des clients 
        categories: [
            'PIVOTEAU SARL',
            'ACTION CONTRE LA SOIF',
            'ACTION CONTRE LE SEXE',
            'ACTION CONTRE L\'ALCOOLISME',
            'ACTION CONTRE L\'ACTION',

        ],
        crosshair: true
    },
    yAxis: {

        title: {
            text: 'Montant (€)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} €</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    ing: {
        enabled: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        // ICI CHOPPER LES TRESORERIES (dans le meme ordre que les noms des clients) logique !!!!
        name: 'Dépenses',
        data: [0, 58, -690, 157, 541]

    }]
});


// GRAPH pour les remises

// highcharts graph
Highcharts.chart('remises_graph', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Remises'
    },
    subtitle: {
        text: 'Source: <a href="https://www.data.gouv.fr/fr/datasets/finances-publiques-departementales/">data.gouv.fr</a>'
    },
    xAxis: {
        // ici chopper les mois ou pas si t'as la flemme ou pas
        categories: [
            'Janvier',
            'Fevrier',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Aout',
            'Septembre',
            'Octobre',
            'Novembre',
            'Decembre'
        ],
        crosshair: true
    },
    yAxis: {
        title: {
            text: 'Montant (€)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} €</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    ing: {
        buttons: {
            contextButton: {
                menuItems: ["downloadPNG", "downloadJPEG", "downloadPDF", "downloadSVG", "separator", "downloadCSV", "downloadXLS", "viewData", "openInCloud"]
            }
        }
    },
    series: [{
        // ICI CHOPPER LES NOMBRE DE REMISES PAR MOIS ( selon la recherche , client ,date etc )
        name: 'Dépenses',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    }]
});


// GRAPH camembert pour les impayes par libelle d'impaye

// highcharts graph

Highcharts.chart('impayes_graph', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Répartition des motifs d\'impayés'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    ing: {
        buttons: {
            contextButton: {
                menuItems: ["downloadPNG", "downloadJPEG", "downloadPDF", "downloadSVG", "separator", "downloadCSV", "downloadXLS", "viewData", "openInCloud"]
            }
        }
    },
    series: [{
        name: 'Impayes',
        colorByPoint: true,
        data: [{

            // BOUCLER ET CHOPPER LE LIBELLE ET LE NOMBRE D'IMPAYES PAR LIBELLE 
            name: 'MEURTRE DU PROPRIETAIRE',
            y: 56.33
        }, {
            name: '-180 balles sur le compte (SOFIANE)',
            y: 24.03,
            sliced: true,
            selected: true
        }, {
            name: 'EPICERIE SOLIDAIRE (YANIS)',
            y: 10.38
        }, {
            name: '1100 EUROS (DENIS)',
            y: 4.77
        }, {
            name: '-900 EUROS DU CROUS (Léon)',
            y: 0.91
        }, {
            name: 'Impayes 6',
            y: 0.2
        }]
    }]
});
