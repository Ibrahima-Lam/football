export const Game = {
    extract: (form) => {
        Game.edit = !!form.edit.value
        Game.id = form.id.value
        Game.home = form.home.value
        Game.away = form.away.value
        Game.date = form.date.value
        Game.heure = form.heure.value
        Game.stade = form.stade.value
        Game.groupe = form.groupe.value
        Game.niveau = form.niveau.value
        return Game
    }
}

export const Competition = {
    extract: (form) => {
        Competition.edit = !!(form.edit?.value ?? false)
        Competition.code = form.code.value
        Competition.nom = form.nom.value
        Competition.localite = form.localite.value
        return Competition
    }
}
export const Edition = {
    extract: (form) => {
        Edition.edit = !!(form.edit?.value ?? false)
        Edition.code = form.code.value
        Edition.annee = form.annee.value
        Edition.nom = form.nom.value
        Edition.competition = form.competition.value
        return Edition
    }
}
export const Groupe = {
    extract: (form) => {
        Groupe.edit = !!(form.edit?.value ?? false)
        Groupe.id = form.id.value
        Groupe.nom = form.nom.value
        Groupe.phase = form.phase.value
        Groupe.edition = form.edition.value
        return Groupe
    }
}

export const Equipe = {
    extract: (form) => {
        Equipe.edit = !!(form.edit?.value ?? false)
        Equipe.id = form.id.value
        Equipe.nom = form.nom.value
        Equipe.libelle = form.libelle.value
        Equipe.localite = form.localite.value
        return Equipe
    }
}
export const Participant = {
    extract: (form) => {
        Participant.edit = !!(form.edit?.value ?? false)
        Participant.id = form.id.value
        Participant.equipe = form.equipe.value
        Participant.edition = form.edition.value

        return Participant
    }
}
export const Participation = {
    extract: (form) => {
        Participation.edit = !!(form.edit?.value ?? false)
        Participation.id = form.id.value
        Participation.groupe = form.groupe.value
        Participation.equipe = form.equipe.value

        return Participation
    }
}
export const Joueur = {
    extract: (form) => {
        Joueur.edit = !!(form.edit?.value ?? false)
        Joueur.id = form.id.value
        Joueur.nom = form.nom.value
        Joueur.equipe = form.equipe.value
        Joueur.localite = form.localite.value

        return Joueur
    }
}
export const Sanction = {
    extract: (form) => {
        Sanction.edit = !!(form.edit?.value ?? false)
        Sanction.id = form.id.value
        Sanction.joueur = form.joueur.value
        Sanction.match = form.match.value
        Sanction.sanction = form.sanction.value
        Sanction.minute = form.minute.value

        return Sanction
    }
}
export const But = {
    extract: (form) => {
        But.edit = !!(form.edit?.value ?? false)
        But.id = form.id.value
        But.joueur = form.joueur.value
        But.match = form.match.value
        But.marque = form.marque.value
        But.equipe = form.equipe.value
        But.minute = form.minute.value

        return But
    }
}
export const Score = {
    extract: (form) => {
        Score.edit = !!(form.edit?.value ?? false)
        Score.id = form.id.value
        Score.home = form.home.value
        Score.away = form.away.value
        return Score
    }
}
export const Tiraubut = {
    extract: (form) => {
        Tiraubut.edit = !!(form.edit?.value ?? false)
        Tiraubut.id = form.id.value
        Tiraubut.home = form.home.value
        Tiraubut.away = form.away.value
        return Tiraubut
    }
}