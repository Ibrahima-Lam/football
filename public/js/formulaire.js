import { getData } from "./src.js";
let games = []
let joueurs = []
let equipes = []
let marques = []
let sanctions = []
let result = null

const setting = {
    type: null,
    refer: null,
    team: null,
    val: null
}




function getGames(res) {
    games = res
}
function getJoueurs(res) {
    joueurs = res
}
function getEquipes(res) {
    equipes = res
}
function getMarques(res) {
    marques = res
}
function getSanctions(res) {
    sanctions = res
}
function getResult(res) {
    result = res
}

async function load() {
    await getData("?p=api/match", getGames)
    await getData("?p=api/joueur", getJoueurs)
    await getData("?p=api/equipe", getEquipes)
    await getData("?p=api/marque", getMarques)
    await getData("?p=api/sanction", getSanctions)

}

window.addEventListener('load', async function (e) {
    await load()
})
const form = document.getElementById('form');
form.addEventListener('submit', async function (e) {
    e.preventDefault()
    const data = {}
    let dt
    if (setting.type === "joueur") {
        data.nom = this.nom.value
        data.equipe = this.equipe.value
        data.localite = this.localite.value
        dt = JSON.stringify(data)
        await getData("?p=api/joueur/post&data=" + dt, getResult)

    } else if (setting.type === "but") {
        data.joueur = this.joueur.value
        data.equipe = this.equipe.value
        data.match = this.match.value
        data.marque = this.marque.value
        data.minute = this.minute.value
        dt = JSON.stringify(data)
        await getData("?p=api/but/post&data=" + dt, getResult)

    } else if (setting.type === "sanction") {
        data.joueur = this.joueur.value
        data.equipe = this.equipe.value
        data.match = this.match.value
        data.sanction = this.sanction.value
        data.minute = this.minute.value
        dt = JSON.stringify(data)
        await getData("?p=api/sanction/post&data=" + dt, getResult)

    }

    if (result.res ?? null) alert("enregistrés avec succes")
    else alert("echec")
    await load()
})

const type = document.getElementById('type');
type.addEventListener('change', function (e) {
    setting.type = this.value
    const param2 = document.querySelector('.param2')
    const param3 = document.querySelector('.param3')
    const param4 = document.querySelector('.param4')
    const form1 = document.querySelector('.form1')
    const form2 = document.querySelector('.form2')
    const form3 = document.querySelector('.form3')
    const form4 = document.querySelector('.form4')
    const form5 = document.querySelector('.form5')
    const formaction = document.querySelector('.param-action')


    param2.innerHTML = ""
    param3.innerHTML = ""
    param4.innerHTML = ""
    initialize()
    function initialize() {
        form1.innerHTML = ""
        form2.innerHTML = ""
        form3.innerHTML = ""
        form4.innerHTML = ""
        form5.innerHTML = ""
        formaction.innerHTML = ""
    }


    if (!setting.type) return
    if (setting.type === "joueur") {
        const name = document.createElement("input")
        name.name = "nom"
        name.placeholder = "Entrer le nom"
        form1.append(name)
        const localite = document.createElement("input")
        localite.name = "localite"
        localite.placeholder = "Entrer le localite"
        form3.append(localite)
        const select0 = document.createElement("select");
        select0.name = "equipe"
        equipes.forEach(element => {
            const opt = document.createElement("option")
            opt.value = element.idParticipant
            opt.innerText = element.nomEquipe
            select0.append(opt)
        });
        form2.append(select0)
        addAction()
        return
    }


    const tmpparam2 = document.getElementById('tmp-param2').content.cloneNode(true);
    param2.append(tmpparam2)

    const paramettre = document.getElementById('paramettre');
    paramettre.addEventListener('change', function (e) {

        setting.refer = this.value
        param3.innerHTML = ""
        param4.innerHTML = ""
        initialize()
        if (!setting.refer) return

        const select0 = document.createElement("select");
        const opt = document.createElement("option")
        select0.append(opt)
        equipes.forEach(element => {
            const opt = document.createElement("option")
            opt.value = element.idParticipant
            opt.innerText = element.nomEquipe
            select0.append(opt)
        });
        param3.append(select0)
        select0.addEventListener("change", function () {
            setting.team = this.value
            param4.innerHTML = ""
            initialize()
            const select = document.createElement("select");
            const opt = document.createElement("option")
            select.append(opt)

            if (setting.refer === "joueur") {
                select.name = "joueur"
                const joueurs = filtreJoueur(setting.team)
                joueurs.forEach(element => {
                    const opt = document.createElement("option")
                    opt.value = element.idJoueur
                    opt.innerText = element.nomJoueur
                    select.append(opt)
                });
            } else if (setting.refer === "match") {
                select.name = "match"
                const games = filtreGame(setting.team)
                games.forEach(element => {
                    const opt = document.createElement("option")
                    opt.value = element.idGame
                    opt.innerText = element.home + "/" + element.away
                    select.append(opt)
                });
            } else if (setting.refer === "equipe") {
                select.name = "equipe"
                const equipes = filtreTeam(setting.team)
                equipes.forEach(element => {
                    const opt = document.createElement("option")
                    opt.value = element.idParticipant
                    opt.innerText = element.nomEquipe
                    select.append(opt)
                });
            }
            param4.append(select)
            select.addEventListener('change', function (e) {
                initialize()
                setting.val = this.value
                const field1 = document.createElement("input")
                field1.type = "hidden"
                let field2 = null
                let field3 = null
                let field4 = null
                const field5 = document.createElement("input")
                field5.name = "minute"
                field5.placeholder = "Entrer les minutes"
                if (setting.refer === "joueur") {
                    field1.name = "joueur"
                    field2 = constructGame()
                    field3 = constructEquipe()
                } else if (setting.refer === "match") {
                    field1.name = "match"
                    field2 = constructJoueur()
                    field3 = constructEquipe()
                } else if (setting.refer === "equipe") {
                    field1.name = "equipe"
                    field2 = constructGame()
                    field3 = constructJoueur()
                }


                if (setting.type === "but") {
                    field4 = constructMarque()
                } else if (setting.type === "sanction") {
                    field4 = constructSanction()
                }
                field1.value = setting.val
                form1.append(field1)
                form2.append(field2)
                form3.append(field3)
                form4.append(field4)
                form5.append(field5)
                addAction()
            })

        })
    })

})

function constructEquipe() {
    const select = document.createElement("select")
    select.name = "equipe"
    equipes.forEach(element => {
        const opt = document.createElement("option")
        opt.value = element.idParticipant
        if (setting.team == element.idParticipant) opt.selected = true
        opt.innerText = element.nomEquipe
        select.append(opt)
    });
    return select

}

function constructSanction() {
    const select = document.createElement("select")
    select.name = "sanction"
    sanctions.forEach(element => {
        const opt = document.createElement("option")
        opt.value = element.codeSanction
        opt.innerText = element.nomSanction
        select.append(opt)
    });
    return select
}

function constructMarque() {
    const select = document.createElement("select")
    select.name = "marque"
    marques.forEach(element => {
        const opt = document.createElement("option")
        opt.value = element.codeMarque
        opt.innerText = element.nomMarque
        select.append(opt)
    });
    return select
}

function constructJoueur() {
    const select = document.createElement("select")
    select.name = "joueur"
    const joueurs = filtreJoueur(setting.team)
    joueurs.forEach(element => {
        const opt = document.createElement("option")
        opt.value = element.idJoueur
        opt.innerText = element.nomJoueur
        select.append(opt)
    });
    return select

}

function constructGame() {
    const select = document.createElement("select")
    select.name = "match"
    const games = filtreGame(setting.team)
    games.forEach(element => {
        const opt = document.createElement("option")
        opt.value = element.idGame
        opt.innerText = element.home + "/" + element.away
        select.append(opt)
    });
    return select
}

function addAction() {
    const tmpaction = document.getElementById('tmp-action').content.cloneNode(true);
    const formaction = document.querySelector('.param-action')
    formaction.append(tmpaction)
}

function filtreGame(team) {
    return games.filter(elmt => {
        return elmt.idHome == team || elmt.idAway == team
    })
}

function filtreJoueur(team) {
    return joueurs.filter(elmt => {
        return elmt.idParticipant == team
    })
}

function filtreTeam(team) {
    return equipes.filter(elmt => {
        return elmt.idParticipant == team
    })
}