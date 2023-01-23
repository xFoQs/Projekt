class Form {
    inputFields;
    object_name;
    object_type;        // 1 for procedure, 0 for regular table
    data;
    form_element;
    fieldset;
    fieldset_fields;
    foreignTableName;

    constructor(object_name, db_data, isProcedure) {
        this.inputFields = [];
        this.fieldset_fields = [];
        this.object_name = object_name;
        this.object_type = isProcedure;
        this.data = db_data;
        this.buildForm(object_name);
    }

    addAnotherAuthor = () => {
        const table = this.data["tables"][this.foreignTableName];
        const foreignFields = table.identifiedBy;
        let newfield;


        for (let ff of foreignFields) {
           
            for (let field of table.fields) {
               
                if (field.fields.name == ff) {
                    newfield = this.createField(field.fields, Math.floor(this.fieldset_fields.length / 2) + 1);
                    
                    this.fieldset.children[1].appendChild(newfield);
                    this.fieldset_fields.push(newfield);
                    this.inputFields.push(newfield);
                }
            }
        }
    }

    buildQuery = () => {


        if (this.object_type) {
            let query = `CALL ${this.object_name}(`;
            
            for (let input of this.inputFields) {
                if (input.type === "number") {
                    
                    query += input.value ? input.value : "null";
                    query += ",";
                }
                else
                    query += input.value.length > 0 ? `"${input.value}",` : 'null,';
            }

            query = query.substring(0, query.length - 1) + ")";
            current_query = query;
            displayTable();
        } else {
            if (this.object_name == "autorzy") {
                let query = `CALL pobierzIdAutora("${this.inputFields[0].value + ' ' + this.inputFields[1].value}", @junk)`;
                fetchQuery(query, "no")
            }

            if (this.object_name == "pracownicy") {
                let query = "INSERT INTO pracownicy (imie, nazwisko, email, haslo, telefon, wynagrodzenie) VALUES (";

                for (let i = 0; i < this.inputFields.length - 1; i++) {
                    query += `"${this.inputFields[i].value}",`;
                    this.inputFields[i].value = "";
                }

                query += `${this.inputFields[this.inputFields.length - 1].value})`;
                fetchQuery(query, "no");
            }
        }
    }

    buildForm (object_name) {

        let form_location;
        let key;
        let object;


        const send_btn = document.createElement("button");


        // form wrapper and heading
        this.form_element = document.createElement("form");
        const form_heading = document.createElement("h2");

        this.form_element.classList.add("my-form");
       

        form_heading.innerText = object_name.replaceAll("_", " ");
        form_heading.classList.add("is-size-2");
        this.form_element.appendChild(form_heading);
        
        if (this.object_type) {
            const object_description = document.createElement("p");

            activateView("procedures");
            form_location = document.querySelector("div#procedures");
            key = "procedures";
            object = this.data[key][object_name];
            object_description.classList.add("is-italic");
            object_description.innerText = object.comment;
            this.form_element.appendChild(object_description);
            send_btn.type = "button";
            send_btn.addEventListener("click", this.buildQuery);
        }
        
        else {
            activateView("preview");
            form_location = document.querySelector("div#preview");
            key = "tables";
            object = this.data[key][object_name];
            send_btn.type = "submit";
            this.form_element.method = "POST";
            this.form_element.action = object_name + ".php";
            this.form_element.enctype="multipart/form-data";

        }

        // form button
        const btn_wrapper = document.createElement("div");

    
        send_btn.innerText = this.object_type ? "Uruchom" : "Dodaj";
        send_btn.classList.add("button", "is-link");
        btn_wrapper.appendChild(send_btn);
    
        const dataset = this.object_type ? [object.parameters] : [object.fields, object.foreignKeys];
        let iter = 0;
        let field;
        let fieldNum;
    
        for (let set of dataset) {
            
            fieldNum = 0;

           

            for (let param of set) {

                  // this means that we need to create fieldset for foreign key
                if (iter >= 1) {
                    this.foreignTableName = param;
                    this.form_element.appendChild(this.createFieldset());
                    continue;
                }

                if (param.hasOwnProperty("fields")) 
                    field = this.createField(param.fields)
                else
                    field = this.createField(param);
    
                // IN means that this parameter is object input
                if ((param.hasOwnProperty("mode") && param.mode === "IN")) {
                    this.form_element.appendChild(field);
                    this.inputFields.push(field.querySelector("input"));
                }

                if (!param.hasOwnProperty("mode") && fieldNum != 0) {
                    this.form_element.appendChild(field);
                    this.inputFields.push(field.querySelector("input"));
                }

               
              
                fieldNum++;
            }

            iter++;
        }

        this.form_element.appendChild(btn_wrapper);
        form_location.innerHTML = "";
        form_location.appendChild(this.form_element);

    }

    createFieldset() {
        this.fieldset = document.createElement("fieldset");
        const legend = document.createElement("legend");
        const addNew = document.createElement("button");
        addNew.type = "button";

        addNew.innerText = "Dodaj kolejnego autora";
        addNew.addEventListener("click", this.addAnotherAuthor);

        addNew.classList.add("button", "is-warning")

        const fieldWrapper = document.createElement("div");
        fieldWrapper.style.margin = "2em 0";

        this.fieldset.appendChild(legend);
        this.fieldset.appendChild(fieldWrapper);
        this.fieldset.appendChild(addNew);

        this.addAnotherAuthor(this.foreignTableName)

        this.fieldset.classList.add("my-fieldset");
        legend.classList.add("my-legend", "has-background-warning", "has-text-weight-bold");
        legend.innerText = this.foreignTableName;

       
        return this.fieldset;
    }
    

    // TODO: create horizontal form and add textarea for book description column
    createField(fieldPropObj, fieldIndex = 0) {
        let wrapper, label, input, inputWrapper; 

        // create elements
        wrapper = document.createElement("div");
        label = document.createElement("label");
        inputWrapper = document.createElement("div");
        input = document.createElement("input");

        // attach css classes
        wrapper.classList.add("field");
        label.classList.add("label");
        inputWrapper.classList.add("control");
        input.classList.add("input");
        label.classList.add("is-capitalized");

        // set properties
        input.name = label.htmlFor = fieldPropObj.name;
        label.innerText = fieldPropObj.name.replaceAll("_", " ");

        if (fieldIndex) {
            input.name = label.htmlFor = fieldPropObj.name + `${fieldIndex}`;
            label.innerText = fieldPropObj.name.replaceAll("_", " ") + ` #${fieldIndex}`;
        }

        // set correct type for input field
        if (fieldPropObj.data_type === "varchar") {
            input.type = "text";
            input.maxLength = fieldPropObj.max_length;
        }

        else if (fieldPropObj.data_type === "image") {
            input.type = "file";
            input.accept ="image/png, image.jpeg";
        }

        else if (fieldPropObj.data_type === "int") {
            input.type = "number";
        }

        else if (fieldPropObj.data_type === "datetime") {
            input.type = "datetime-local";
        }

        else if (fieldPropObj.data_type === "email") {
            input.type = "email";
        }

        else if (fieldPropObj.data_type === "text") {
            input.type = "text";
        }
        
        inputWrapper.appendChild(input);
        wrapper.appendChild(label);
        wrapper.appendChild(inputWrapper);

        return wrapper;
    }
}