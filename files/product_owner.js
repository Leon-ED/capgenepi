
/**
 * 
 * Partie pour gérer l'affichage et le désaffichage des onglets de recherche
 */
const po_search_tab = document.querySelector('.po_search-tab');
const po_search_tab_a = po_search_tab.querySelectorAll('a');

po_search_tab_a.forEach(a => {
    a.addEventListener('click', function (e) {
        e.preventDefault();
        po_search_tab_a.forEach(a => {
            a.removeAttribute('data-selected');
        });
        this.setAttribute('data-selected', 'true');
        //set display flex to the div with the same id as the data-tab attribute of the clicked link
        document.querySelector('#' + this.getAttribute('data-tab')).style.display = 'flex';
        //set display none to the div with the same id as the data-tab attribute of the other links
        po_search_tab_a.forEach(a => {
            if (a.getAttribute('data-tab') !== this.getAttribute('data-tab')) {
                document.querySelector('#' + a.getAttribute('data-tab')).style.display = 'none';
            }
        }
        );
    });

});


