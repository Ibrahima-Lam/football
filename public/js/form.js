import * as OBJ from "./objet.js";

async function loader(uri) {
    return await (await fetch(uri)).text()
}

export async function loginForm(id = null) {
    const uri = '?p=app/formulaire'
    return await (await fetch(uri)).text()
}
export async function competitionForm(id = null) {
    const uri = id ? '?p=form/competition/' + id : '?p=form/competition'
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Competition.extract(form)
        return await loader('?p=traitement/competition&data=' + JSON.stringify(obj))
    }]
}
export async function editionForm(id = null, competition = null) {
    let uri = '?p=form/edition'
    uri += id ? '/' + id : ''
    uri += competition ? '&competition=' + competition : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Edition.extract(form)
        return await loader('?p=traitement/edition&data=' + JSON.stringify(obj))
    }]
}
export async function participationForm(id = null, groupe = null) {
    let uri = '?p=form/participation'
    uri += id ? '/' + id : ''
    uri += groupe ? '&groupe=' + groupe : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Participation.extract(form)
        return await loader('?p=traitement/participation&data=' + JSON.stringify(obj))
    }]
}
export async function equipeForm(id = null) {
    let uri = '?p=form/equipe'
    uri += id ? '/' + id : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Equipe.extract(form)
        return await loader('?p=traitement/equipe&data=' + JSON.stringify(obj))
    }]
}
export async function joueurForm(id = null, equipe = null) {
    let uri = '?p=form/joueur'
    uri += id ? '/' + id : ''
    uri += equipe ? '&equipe=' + equipe : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Joueur.extract(form)
        return await loader('?p=traitement/joueur&data=' + JSON.stringify(obj))
    }]
}
export async function sanctionForm({ id = null, match = null, equipe = null, joueur = null }) {
    let uri = '?p=form/sanction'
    uri += id ? '/' + id : ''
    uri += match ? '&match=' + match : ''
    uri += equipe ? '&equipe=' + equipe : ''
    uri += joueur ? '&joueur=' + joueur : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Sanction.extract(form)
        return await loader('?p=traitement/sanction&data=' + JSON.stringify(obj))
    }]
}
export async function butForm({ id = null, match = null, equipe = null, joueur = null }) {
    let uri = '?p=form/but'
    uri += id ? '/' + id : ''
    uri += match ? '&match=' + match : ''
    uri += equipe ? '&equipe=' + equipe : ''
    uri += joueur ? '&joueur=' + joueur : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.But.extract(form)
        return await loader('?p=traitement/but&data=' + JSON.stringify(obj))
    }]
}
export async function groupeForm(id = null, edition = null) {
    let uri = '?p=form/groupe'
    uri += id ? '/' + id : ''
    uri += edition ? '&edition=' + edition : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Groupe.extract(form)
        return await loader('?p=traitement/groupe&data=' + JSON.stringify(obj))
    }]
}
export async function participantForm(id = null, edition = null) {
    let uri = '?p=form/participant'
    uri += id ? '/' + id : ''
    uri += edition ? '&edition=' + edition : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Participant.extract(form)
        return await loader('?p=traitement/participant&data=' + JSON.stringify(obj))
    }]
}
export async function matchForm(groupe, id = null) {
    let uri = '?p=form/match/' + groupe
    uri += id ? '/' + id : ''
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Game.extract(form)
        return await loader('?p=traitement/match&data=' + JSON.stringify(obj))
    }]
}
export async function scoreForm(id) {
    let uri = '?p=form/score/' + id
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Score.extract(form)
        return await loader('?p=traitement/score&data=' + JSON.stringify(obj))
    }]
}
export async function tiraubutForm(id) {
    let uri = '?p=form/tiraubut/' + id
    return [await (await fetch(uri)).text(), async function (form) {
        const obj = OBJ.Tiraubut.extract(form)
        return await loader('?p=traitement/tiraubut&data=' + JSON.stringify(obj))
    }]
}