let ksiazki = [];
let iloscK;
let index;

function cookie() {
    let arr = []
    for(let i in ksiazki) {
        arr.push(ksiazki[i].id)
    }

  createCookie("height", arr, "1");

function createCookie(name, value, days) {
  var expires;
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();
  }
  else {
    expires = "";
  }
  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}
  }

function ss() {
    localStorage.setItem('ksiazki', JSON.stringify(ksiazki));
}

function ls() {
    if(JSON.parse(localStorage.getItem('ksiazki')) !== null) {
        ksiazki = JSON.parse(localStorage.getItem('ksiazki'))
    } else {
        ss();
    }
}


function cs() {
    localStorage.clear();
}

function ile(id_ksiazka) {
    index = ksiazki.findIndex(elem => elem.id === id_ksiazka);
    // console.log(index);
    iloscK = ksiazki[index].ilosc;
}

function czyZero(id_ksiazka) {
    ile(id_ksiazka);
    if(ksiazki === undefined ||  ksiazki == null || iloscK == 0) {
        return true;
    } else {
        return false;
    }
}

function dodaj(id_ksiazka, tytul='Default') {
    
    ls();

    if(ksiazki === undefined ||  ksiazki == null || ksiazki.length == 0) {
        ksiazki.push({'id': id_ksiazka, 'ilosc': 1, 'tytul': tytul});
    } else {
        if(ksiazki.some(elem => elem.id === id_ksiazka)) {
            ile(id_ksiazka);
            ksiazki[index].ilosc++;
        } else {
            ksiazki.push({'id': id_ksiazka, 'ilosc': 1, 'tytul': tytul});
        }
    }
    // else if(find) {
    //     ile(id_ksiazka);
    //     ksiazki[index].ilosc++;
    // } else {
    //     ksiazki.push({'id': id_ksiazka, 'ilosc': 1});
    // }

    ss();
    cookie();
}

// function dodajShelf(id_ksiazka) {
//     dodaj(id_ksiazka);
//     const children = document.getElementById(id_ksiazka).children[1];
//     const rdChildren = children.children[1];
//     rdChildren.innerText = ksiazki[index].ilosc++;
// }

function usun(id_ksiazka) {
    ls();

    if(ksiazki === undefined || ksiazki.length == 0 || ksiazki == null) {
        
    } else {
        if(ksiazki.some(elem => elem.id === id_ksiazka)) {
            if(!czyZero(id_ksiazka)) {
                ile(id_ksiazka);
                ksiazki[index].ilosc--;
            }
        }
    }
    // else if(find) {
    //     ile(id_ksiazka);
    //     ksiazki[index].ilosc++;
    // } else {
    //     ksiazki.push({'id': id_ksiazka, 'ilosc': 1});
    // }

    ss();
    cookie();
}

// function usunShelf(id_ksiazka) {
//     usun(id_ksiazka);
//     const children = document.getElementById(id_ksiazka).children[1];
//     const rdChildren = children.children[1];
//     rdChildren.innerText = ksiazki[index].ilosc--;
// }

function X(id_ksiazka) {
    ls();
    
    ile(id_ksiazka);
    ksiazki.splice(index, 1);
    const div = document.getElementById(id_ksiazka);
    div.remove();
    
    window.location.reload();

    ss();
    cookie();
}

function pokaz() {
    ls();

    // ss();

    for(let ksiazka in ksiazki) {
        let div = document.createElement('div');
        div.classList.add('box');
        div.classList.add('is-flex');
        div.classList.add('is-flex-direction-row');
        div.classList.add('is-flex-wrap-nowrap');
        div.classList.add('is-justify-content-space-between');
        div.id = ksiazki[ksiazka].id;
    
        let txtNazwa = Object.values(ksiazki[ksiazka])[2];
        console.log(ksiazki);
        let h1_1 = document.createElement('h1');
        h1_1.classList.add('title');
        h1_1.innerText = txtNazwa;
    
        let divH1 = document.createElement('div');
        divH1.classList.add('divH1');
        divH1.append(h1_1);

        let buttonAdd = document.createElement('button');
        buttonAdd.classList.add('button');
        buttonAdd.classList.add('is-medium');
        buttonAdd.classList.add('is-primary');
        buttonAdd.setAttribute('onClick', 'dodajShelf(this.name)');
        buttonAdd.name = ksiazki[ksiazka].id;
        buttonAdd.innerText = "+";

        let txtIlosc = ksiazki[ksiazka].ilosc;
        let h1_2 = document.createElement('h1');
        h1_2.classList.add('title');
        h1_2.setAttribute('name', 'ilosc');
        h1_2.innerText = txtIlosc;
    
        let buttonRemove = document.createElement('button');
        buttonRemove.classList.add('button');
        buttonRemove.classList.add('is-medium');
        buttonRemove.classList.add('is-danger');
        buttonRemove.setAttribute('onClick', 'usunShelf(this.name)');
        buttonRemove.name = ksiazki[ksiazka].id;
        buttonRemove.innerText = "-";
    
        let buttonX = document.createElement('button');
        buttonX.classList.add('delete');
        buttonX.setAttribute('onClick', 'X(this.name)'); 
        buttonX.name = ksiazki[ksiazka].id;

        let divX = document.createElement('div');
        divX.classList.add('divX');
        divX.append(buttonX);
        
        let divButton = document.createElement('div');
        divButton.classList.add('is-flex');
        divButton.classList.add('is-flex-direction-row');
        divButton.classList.add('is-flex-wrap-nowrap');
        divButton.classList.add('is-justify-content-space-between');
        divButton.classList.add('divButton');

        // let con = [buttonAdd, h1_2, buttonRemove];

        // for(let i in con) {
        //     divButton.append(con[i]);
        // }

        let ele = [divH1, divX];

        for(let i in ele) {
            div.append(ele[i]);
        }

        let div1 = document.getElementById('div1');
        div1.append(div);
    }
}