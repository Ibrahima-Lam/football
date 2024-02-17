
export async function getData(url, callback = null) {
    const data = await fetch(url)
    const res = await data.json()
    if (callback) callback(res)
    return res
}
export async function loadParticipation() {
    const uri = '?p=api/participation'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadGroupe() {
    const uri = '?p=api/groupe'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadStat() {
    const uri = '?p=api/stat'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadMatch() {
    const uri = '?p=api/match'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadEquipe() {
    const uri = '?p=api/equipe'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadJoueur() {
    const uri = '?p=api/joueur'
    const req = await fetch(uri)
    return await req.json()

}

export async function loadBut(somme = true) {
    const uri = somme ? '?p=api/joueur/buteur' : '?p=api/joueur/but'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadSanction(somme = true) {
    const uri = somme ? '?p=api/joueur/sanction' : '?p=api/joueur/sanctionner'
    const req = await fetch(uri)
    return await req.json()

}
export async function loadAdvencedSanction(susp = true) {
    const uri = susp ? '?p=api/joueur/suspension' : '?p=api/joueur/avertissement'
    const req = await fetch(uri)
    return await req.json()

}
export class DialogTag {
    parent
    content
    title
    dialog
    get element() { return this.dialog }
    constructor(parent, content = null, title = 'Formulaire') {
        this.parent = parent
        this.title = title
        if (content) this.content = content
        this.dialog = document.createElement('dialog')
        this.dialog.classList.add('dialog')
        this.parent.append(this.dialog)
    }
    set(content, title = null) {
        this.content = content
        this.title = title
        this.#initialize()
    }
    #initialize() {
        const tag = `
     <div class="dialog-head">
             <h3>${this.title}</h3>
         </div>
         <div class="dialog-body">
            ${this.content}
         </div>
         <div class="dialog-foot"><button class="btn btn-danger" id="ferme">Fermer</button></div>
    `
        this.dialog.innerHTML = tag
        this.dialog.querySelector('#ferme').addEventListener('click', () => this.close())
    }
    show() {
        this.#initialize()
        if (!this.dialog.open) this.dialog.showModal()
    }
    close() {
        if (this.dialog.open) this.dialog.close()
    }
    remove() {
        this.dialog.remove()
    }

}

export class Calendar {
    date
    mois = ["Janvier", "Février", "Mars", "Avril", "Mais", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Descembre"]
    semaine = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"]

    constructor(date) {
        this.date = date
    }

    jourSemaine(dt = null) {
        return this.semaine[dt?.getDay() ?? this.date.getDay()]
    }

    nomMois(dt = null) {
        return this.mois[dt?.getMonth() ?? this.date.getMonth()]
    }

    finDuMois(dt = null) {
        const end = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
        if (this.date.getFullYear() % 4 === 0) end[1] = 29
        return end[dt?.getMonth() ?? this.date.getMonth()]
    }

    premierJour() {
        const dt = this.date
        dt.setDate(1)
        return {
            index: dt.getDay(),
            nom: this.jourSemaine(dt)
        }
    }

    dernierJour() {
        const dt = this.date
        dt.setDate(this.finDuMois())
        return {
            index: dt.getDay(),
            nom: this.jourSemaine(dt)
        }
    }

    frDate() {

        return `${this.jourSemaine()}, le ${this.date.getDate()} ${this.nomMois()} ${this.date.getFullYear()}`
    }

    frDayDate() {
        const date = this.date
        date.setMinutes(date.getMinutes() + 1)

        const dt = new Date()
        let day = dt.getDate()
        dt.setHours(0, 0, 0)

        const dt1 = new Date()
        dt1.setDate(day + 1)
        dt1.setHours(0, 0, 0)

        if (+date.getTime() > +dt.getTime() && +date.getTime() < +dt1.getTime()) return "Aujourd'hui"

        dt.setDate(day + 1)
        dt1.setDate(day + 2)
        if (+date.getTime() > +dt.getTime() && +date.getTime() < +dt1.getTime()) return "Demain"
        dt.setDate(day - 1)
        dt1.setDate(day)
        if (+date.getTime() > +dt.getTime() && +date.getTime() < +dt1.getTime()) return "Hier"
        return this.frDate()
    }

    next() {
        const date = new Date()
        date.setHours(0, 0, 0)
        return this.date.getTime() >= date.getTime()
    }
}