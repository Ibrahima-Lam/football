export const Table = {
    editable: false,
    setEditable: (val) => Object.defineProperty(Table, 'editable', {
        value: val
    }),
    tr: ({
        idParticipant,
        idParticipation,
        nomEquipe,
        nomGroupe,
        idEquipe
    }) => {

        const edit = Table.editable ? ` <td><details><summary></summary>
        <button class='button action-participation' data-id='${idParticipation} 'data-form='participation'>Editer la participation</button>
        <button class='button action-equipe' data-equipe='${idEquipe} 'data-form='equipe'>editer l'equipe</button>
        </details>
        </td>` : ''
        return ` <tr>
                    <td>${idParticipant}</td>
                      <td><a class='link' href='?p=equipe/details&equipe=${idParticipant}'> ${nomEquipe} </a></td>
                    <td>${nomGroupe}</td>
                    ${edit}
                </tr> `
    },
    tab: (content) => {
        const edit = Table.editable ? ` <th>Actions</th>` : ''
        return `  
             <div class="table-container">
            <table class="table striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Groupe</th>
                    ${edit}
                </tr>
            </thead>
            <tbody>
                 ${content} 
            </tbody>
        </table>
         </div>
        
        `
    }

}