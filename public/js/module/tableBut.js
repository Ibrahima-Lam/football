
export const Table = {
    tr: ({ num, idTeam, idJoueur, nomJoueur, nomEquipe, team, nombre }) => {
        return `
            <tr>
                        <td>
                            <div class="player">
                                <div class="player-profil">
                                    ${num}
                                </div>
                                <div class="player-text">
                                    <div class="player-nom">     <a class='link' href='?p=joueur/details&joueur=${idJoueur}'>${nomJoueur}</a> </div>
                                    <div class="player-equipe">${nomEquipe} </div>
                                </div>
                            </div>
                        </td>
                          <td><a class='link' href='?p=equipe/details&equipe=${idTeam}'> ${team} </a></td>

                       
                        <td>
                            ${nombre} 
                        </td>
                    </tr>
        `
    },
    /**
     * 
     * @param {array} tab 
     * @returns {String}
     */
    tbody: (tab) => {
        if (tab.length == 0) return `<p class="titre flex">Pas de But </p>`
        return `
         <table class="table striped">
                <thead>
                    <tr>
                       
                    <th>Joueur</th>
                    <th>Equipe</th>
                    <th>Nombre de but</th>
              
                    </tr>
                </thead>
                <tbody>
                ${tab.map(elmt => Table.tr(elmt)).join('')}
                </tbody>
        
        `
    }

}
export const TableNonCumule = {
    tr: ({ idJoueur, nomJoueur, nomEquipe, idTeam, team, nomMarque, idGame, dateGame }) => {
        return `
            <tr>
                        <td>
                            <div class="player">
                                <div class="player-profil">
                                  ${nomJoueur.substring(0, 1).toUpperCase()}
                                </div>
                                <div class="player-text">
                                  <div class="player-nom">     <a class='link' href='?p=joueur/details&joueur=${idJoueur}'>${nomJoueur}</a> </div>

                                    <div class="player-equipe">${nomEquipe} </div>
                                </div>
                            </div>
                        </td>
                           <td><a class='link' href='?p=equipe/details&equipe=${idTeam}'> ${team} </a></td>

                        <td>
                            ${nomMarque} 
                        </td>
                     
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
        if (tab.length == 0) return `<p class="titre flex">Pas de But </p>`
        return `
         <table class="table striped">
                <thead>
                    <tr>
                       
                    <th>Joueur</th>
                    <th>Equipe</th>
                    <th>But Marqué</th>
                    <th>Date</th>
              
                    </tr>
                </thead>
                <tbody>
                ${tab.map(elmt => TableNonCumule.tr(elmt)).join('')}
                </tbody>
        
        `
    }

}