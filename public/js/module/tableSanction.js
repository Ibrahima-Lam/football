
export const Table = {
    tr: ({ idJoueur, nomJoueur, nomEquipe, nomSanction, idGame, idParticipant, dateGame }) => {
        return `
            <tr>
                            <td> ${idJoueur} </td>
                            <td> <a class='link' href='?p=joueur/details&joueur=${idJoueur}'>${nomJoueur}</a> </td>
                            <td><a class='link' href='?p=equipe/details&equipe=${idParticipant}'> ${nomEquipe} </a></td>
                            <td> ${nomSanction} </td>
                            <td><a class='link' href='?p=match/details&match=${idGame}'> ${dateGame}</a> </td>
            </tr>
        `
    },
    /**
     * 
     * @param {array} tab 
     * @returns {String}
     */
    tbody: (tab) => {
        if (tab.length == 0) return `<p class="titre flex">Pas de Sanction </p>`
        return `
         <table class="table striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th> Equipe</th>
                        <th> Sanction</th>
                        <th> Date</th>
                       
                    </tr>
                </thead>
                ${tab.map(elmt => Table.tr(elmt)).join('')}
                <tbody>
        
        `
    }

}
export const TableSusp = {
    tr: ({ idJoueur, nomJoueur, nomEquipe, nomSanction, idParticipant, nombreCarton }) => {
        return `
            <tr>
                            <td> ${idJoueur} </td>
                              <td> <a class='link' href='?p=joueur/details&joueur=${idJoueur}'>${nomJoueur}</a> </td>
                            <td><a class='link' href='?p=equipe/details&equipe=${idParticipant}'> ${nomEquipe} </a></td>
                            <td> ${nomSanction} </td>
                            <td> ${nombreCarton} </td>
            </tr>
        `
    },
    /**
     * 
     * @param {array} tab 
     * @returns {String}
     */
    tbody: (tab) => {
        if (tab.length == 0) return `<p class="titre flex">Pas de Sanction </p>`
        return `
         <table class="table striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th> Equipe</th>
                        <th> Sanction</th>
                        <th> Nbr. Carton</th>
                       
                    </tr>
                </thead>
                ${tab.map(elmt => TableSusp.tr(elmt)).join('')}
                <tbody>
        
        `
    }

}