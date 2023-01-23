const panel = document.querySelector(".panel");
const tabs = document.querySelectorAll(".tabs > ul > li");
const views = document.querySelectorAll(".view");
const preview_node = document.querySelector("#preview");

let db_data;
let panel_groups;
let panel_tabs;
let filter_set;
let current_query;
let current_query_view;
let selected_table;
let import_fn_input = document.querySelector("input[name='import-fn']");

const activateView = (view_name) => {
    
    document.querySelectorAll(".view").forEach((elem) => {
        elem.classList.add("invisible");
    });

    document.querySelectorAll("li[data-view]").forEach((elem) => {
        elem.classList.remove("is-active");
    });

    document.querySelector(`.view#${view_name}`).classList.remove("invisible");
    document.querySelector(`li[data-view='${view_name}']`).classList.add("is-active");
}

const createPanel = (db_data) => {
    // create panel-group for tables, views and procedures
    const groups = document.querySelectorAll(".panel-group");

    for (let child of groups) panel.removeChild(child);

    const p1 = document.createElement("p");
    p1.classList.add("panel-heading");
    p1.innerText = "Biblioteka";

    for (let prop in db_data) {
        const group = document.createElement("div");
        group.classList.add('panel-group');
        group.dataset["id"] = prop;

        for (let prop2 in db_data[prop]) {
            const link = document.createElement('a');
            link.dataset[prop] = prop2;
            
            if (prop != "procedures")
                link.classList.add("table-link");
            else
                link.classList.add("procedure-link");

            link.classList.add("panel-block");
            link.innerText = prop2;
            group.appendChild(link);
        }
        
        // hide all panel-group
        group.classList.add("invisible");
        panel.appendChild(group);
    }

    panel_groups = document.querySelectorAll(".panel-group");
    panel_tabs = document.querySelectorAll(".panel-tabs > a");

    // show panel-group for tables
    let el = document.querySelector(".panel-group[data-id=tables");
    el.classList.remove("invisible");
    el.classList.add("is-active");

    // hide all panel-groups except first one
    for (let i = 1; i < panel_groups.length; i++) {
        panel_groups[i].classList.add("invisible");
    }

    document.querySelectorAll(".table-link").forEach((node) => {

        activateView("preview");

        
        node.addEventListener("click", (elem) => {
            let set = elem.target.dataset;
            let table_name = set.tables ? set.tables : set.views;
            selected_table = set.tables;

            // show add button

            const tn = elem.target.dataset.tables;
            const btn = document.querySelector("#add-record");

            if (["autorzy", "ksiazki", "pracownicy"].includes(tn)) {
                btn.value = tn;
                btn.classList.remove("invisible");
            }
            else {
                btn.classList.add("invisible");
            }


            current_query = `SELECT * FROM \`${table_name}\``;
            displayTable();
        });
    });

    document.querySelectorAll(".procedure-link").forEach((node) => {
        node.addEventListener("click", (elem) => {
            new Form(elem.target.dataset.procedures, db_data, 1);
        })
    })


    tabs.forEach((el) => {
        el.addEventListener("click", switchTab);
    });

}

const initUI = async () => {
    // load database information
    db_data = await fetchDBinfo();
    createPanel(db_data);

    // create select input for import dialog box
    const wrapper = document.createElement("div");
    const select = document.createElement("select");

    document.querySelector("#add-record").addEventListener("click",(elem) => {
        new Form(selected_table, db_data, 0);
    });

    wrapper.classList.add("select");
    wrapper.appendChild(select);
    select.name = "table-name";

    for (let t in db_data.tables) {
        const opt = document.createElement("option");
        opt.value = opt.innerText = t;
        select.appendChild(opt);
    }

    document.querySelector(".form-fields").appendChild(wrapper);

    // attach listeners to various DOM elements
    document.querySelector("#export-btn").addEventListener("click", exportData);
    document.querySelectorAll(".my-notification button.delete").forEach(btn => {
        btn.addEventListener("click", (elem) => {
            elem.target.parentNode.classList.add("invisible");
        })
    });

    document.querySelectorAll(".panel-tabs > a").forEach(btn => {
        btn.addEventListener("click", switchPanelTab);
    });

    document.querySelectorAll(".import-toggle").forEach((elem) => {
        elem.addEventListener("click", toggleImportBox);
    });

    document.querySelectorAll(".export-toggle").forEach((elem) => {
        elem.addEventListener("click", toggleExportBox);
    });

  
}

const switchPanelTab = async (el) => {
    db_data = await fetchDBinfo();
    createPanel(db_data);
    // hide all panel-groups
    for (let i = 0; i < panel_groups.length; i++) {
        panel_groups[i].classList.add("invisible");
        panel_tabs[i].classList.remove("is-active");
    }
    el.target.classList.add("is-active");
    // show panel-group associated with clicked link in panel-tabs
    let elem = document.querySelector(`.panel-group[data-id=${el.target.dataset.group}]`);
    elem.classList.remove("invisible");

    const group = el.target.dataset.group;

    // show additional tabs when user picks queries option
    if (group === "procedures") {
        tabs[0].classList.remove("invisible");
        tabs[1].classList.remove("invisible");
        document.querySelector("#import-top").classList.add("invisible");
    }
    else {
        tabs[0].classList.add("invisible");
        tabs[1].classList.add("invisible");
        document.querySelector("#import-top").classList.add("invisible");
    }

    if (group === "tables") {
        document.querySelector("#import-top").classList.remove("invisible");
    }


}

const switchTab = (el) => {
    // hide all tabs
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("is-active");
    }
    // show panel-group associated with clicked link in panel-tabs
    const parent = el.target.parentNode;
    parent.classList.add("is-active");
    views.forEach(element => {
        element.classList.add("invisible");
    });

    const view = parent.dataset.view;
    current_query_view = document.querySelector(`#${view}`);
    current_query_view.classList.remove("invisible");

}

// function is async because function fetchQuery uses FetchAPI to get data from database
const displayTable = async (data = null) => {
    const wrapper = document.createElement("div");
    const table = document.createElement("table");
    const table_header = document.createElement("thead");
    const table_header_row = document.createElement("tr");
    const table_body = document.createElement("tbody");

    wrapper.classList.add("my-table");
    wrapper.appendChild(table);

    table.classList.add("table", "is-bordered", "is-narrow", "is-hoverable");
    table.appendChild(table_header);
    table.appendChild(table_body);

    table_header.appendChild(table_header_row);
    console.log(current_query);

    data = data == null ? await fetchQuery(current_query, "no") : data;

    if (data.length > 0) {
        const headers = data[0];

        let temp;

        if (current_query.includes("filtr_zamówienia") || current_query.includes("filtr_wypożyczenia")) {
            temp = document.createElement("th");
            temp.innerText = "akcja";
            table_header_row.appendChild(temp);
        }

        // create table header
        for (let x of headers) {
            temp = document.createElement("th");
            temp.innerText = x;
            table_header_row.appendChild(temp);
        }

        // insert data
        const len = data[0].length;
        let temp2;

        const isOrder = current_query.includes("filtr_zamówienia");
        const isReturn = current_query.includes("filtr_wypożyczenia");
        // insert rows
        for(let i = 1; i < data.length; i++) {
            temp2 = document.createElement("tr");

            if (isOrder || isReturn) {
                const form = document.createElement("form");
                const button = document.createElement("button");

                form.action = isOrder ? "wydajKsiazke.php" : "przyjmijKsiazki.php";
                form.method = "POST";

                button.type = "submit";
                button.value = data[i][2];
                button.name = "idWypozyczenie";
                button.innerText = isOrder ? "Wypożycz" : "Przyjmij";
                button.classList.add("button", "is-info", "is-small");

                temp = document.createElement("td");
               
                temp.appendChild(form);
                form.appendChild(button);
                temp2.appendChild(temp);
            }



            for (let j = 0; j < len; j++) {
                temp = document.createElement("td");
                temp.innerText = data[i][j];
                temp2.appendChild(temp);
            }

            table_body.appendChild(temp2);
        }

        // replace old table with new one
        preview_node.innerHTML = wrapper.outerHTML;
    }

    else {
        preview_node.innerHTML = "<b>Tabela jest pusta<br>";
    }
}

const toggleExportBox = (elem) => {
    document.querySelector(".message-wrapper#export-wrapper")
        .classList.toggle("invisible");
    document.querySelector("#download-link")
        .classList.add("invisible");
    document.querySelector("input[name='filename'").value = "";
}

const toggleImportBox = (elem) => {
    document.querySelector(".message-wrapper#import-wrapper")
        .classList.toggle("invisible");
}

const previewFile = async () => {
    const table = document.createElement("table");
    const separator = document.querySelector("input[name='import-sep']").value;
    const wrapper = document.querySelector("div#import-preview");

    const file = import_fn_input.files[0];
    let rows = await file.text().then((response) => response);

    rows = rows.split("\n");
    wrapper.innerHTML = "";
    wrapper.classList.add("my-table");
    wrapper.appendChild(table);

    table.classList.add("my-table", "table", "is-narrow", "is-bordered", "is-hoverable");

    let temp;
    let temp2;
    let columns;

    for (let i = 0; i < 10; i++) {
        temp = document.createElement("tr");
        columns = rows[i].split(separator);

        for (let j = 0; j < columns.length; j++) {
            temp2 = document.createElement("td");
            temp2.innerText = columns[j];
            temp.appendChild(temp2);
        }

        table.appendChild(temp);
    }
}

initUI();
