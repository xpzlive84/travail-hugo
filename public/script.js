let date = new Date();
let zoneMois = document.querySelector('.mois')
let precedent = document.querySelector('.precedent')
let suivant = document.querySelector('.suivant')
let mois = date.toLocaleString('fr-Fr',{
    month:'long',
    year :'numeric'
})
let tbody = document.querySelector('tbody')


document.addEventListener('DOMContentLoaded',()=>{

    zoneMois.innerHTML = mois
    recupererInscrit(date);
})

suivant.addEventListener('click',()=>{
    let moisSuivant = new Date(date.setMonth(date.getMonth()+1))
    let moisEntier = date.toLocaleString('fr-Fr',{
        month:'long',
        year :'numeric'
    })
    recupererInscrit(moisSuivant)
    zoneMois.innerHTML = moisEntier
    while (tbody.firstChild){
        tbody.removeChild(tbody.lastChild)
    }
})

precedent.addEventListener('click',()=>{
    let moisPrecedent = new Date(date.setMonth(date.getMonth()-1))
    let moisEntier = date.toLocaleString('fr-Fr',{
        month:'long',
        year :'numeric'
    })
    recupererInscrit(moisPrecedent)
    zoneMois.innerHTML = moisEntier
    while (tbody.firstChild){
        tbody.removeChild(tbody.lastChild)
    }
})
function recupererInscrit(month){
    let premier = new Date(month.getFullYear(), month.getMonth(), 1)
    let lastDay = new Date(month.getFullYear(), month.getMonth() + 1, 0)


    const post = JSON.stringify({
        debut: premier.toLocaleString('fr-Fr', {
            day: 'numeric',
            month: 'numeric',
            year: 'numeric',
        }),
        fin: lastDay.toLocaleString('fr-FR', {
            day: 'numeric',
            month: 'numeric',
            year: 'numeric',
        }),
    })

    fetch('/recupererInscrit',{
        method:'POST',
        body: post
    })
        .then((response)=>{
            return response.json()
        })
        .then((response)=>{
            for (let i = 0; i <response.length ; i++) {
                const prospect = response[i];
                let tr = document.createElement('tr')
                let tdNom = document.createElement('td')
                let tdPrenom = document.createElement('td')
                let tdEmail = document.createElement('td')
                let tdTel = document.createElement('td')
                let tdRem = document.createElement('td')
                let tdDate = document.createElement('td')

                tdNom.innerHTML = prospect.nom
                tr.appendChild(tdNom)
                tdPrenom.innerHTML = prospect.prenom
                tr.appendChild(tdPrenom)
                tdEmail.innerHTML = prospect.mail
                tr.appendChild(tdEmail)
                tdTel.innerHTML = prospect.telephone
                tr.appendChild(tdTel)
                tdRem.innerHTML = prospect.remarque
                tr.appendChild(tdRem)
                tdDate.innerHTML = prospect.date
                tr.appendChild(tdDate)
                tbody.appendChild(tr)

            }
        })
}