import { Calendar } from "../src.js";
export const Match = {
    date: (date) => {
        return date ? `
         <div class="match-date">
                    <div class="mtch">
                        <span class="day">${(new Calendar(new Date(date))).frDayDate()}</span>
                    </div>
                </div>
        `: ''
    },
    game: (match) => {
        const val = match.homeScore != null && match.awayScore != null ? match.homeScore + '-' + match.awayScore : (match.heureGame ? match.heureGame : 'vs')
        const homep = match.homeScorePenalty != null && match.awayScorePenalty != null ? `(${match.homeScorePenalty})` : ''
        const awayp = match.homeScorePenalty != null && match.awayScorePenalty != null ? `(${match.awayScorePenalty})` : ''
        return `
        <div class="match-row" data-id='${match.idGame}'>

                <div class="match-body element">
                    <div class="match-left">

                    </div>
                    <div class="match-middle ">
                        <span class="home">   <a class='link' href='?p=equipe/details&equipe=${match.idHome}'> ${match.home} </a></span>
                           ${homep} <span class="vs"> ${val}</span>${awayp}
                        <span class="home">   <a class='link' href='?p=equipe/details&equipe=${match.idAway}'> ${match.away} </a></span>

                    </div>
                    <div class="match-right">
                       
                    </div>
                </div>
            </div>
        `
    },
    handleClick: () => {
        const elements = document.querySelectorAll('.match-row')
        elements.forEach(element => {
            element.addEventListener('dblclick', function (e) {
                window.location.assign(`?p=match/details&match=${element.dataset.id}`)
            })
            /*   const vs = element.querySelector('.vs')
              vs.addEventListener('dblclick', function (e) {
                  e.stopImmediatePropagation()
                  alert('vs')
              }) */
        });
    }



}