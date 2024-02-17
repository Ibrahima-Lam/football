export const Table = {

    tab: (tab) => {

        if (tab.length == 0) return `<p class="titre flex">Pas de statistique </p>`
        return `<div class="table-container">
            <table class="table striped">
                <thead>
                    <tr>
                        <th>Num.</th>
                        <th>Equipes</th>
                        <th>Matchs</th>
                        <th>NV</th>
                        <th>NN</th>
                        <th>ND</th>
                        <th>Points</th>
                        <th>Diff</th>
                        <th>BM</th>
                        <th>BE</th>
                    </tr>
                </thead>
                <tbody>
                ${tab?.map(elmt => Table.tr(elmt)).join('')}
                </tbody>
            </table>
        </div>`
    },
    tr: ({ id, num, nom, matchs, nv, nn, nd, points, diff, bm, be }) => {
        if (!(nom ?? null)) return
        return `
        <tr>
                        <td>${num} </td>
                           <td><a class='link' href='?p=equipe/details&equipe=${id}'> ${nom} </a></td>
                        <td>${matchs} </td>
                        <td>${nv} </td>
                        <td>${nn} </td>
                        <td>${nd} </td>
                        <td>${points} </td>
                        <td>${diff} </td>
                        <td>${bm} </td>
                        <td>${be} </td>
                    </tr>
        `
    }
}