'use strict';

let Todo = function () {
};

Todo.prototype = {
    baseUrl: 'api/',
    addButton: null,
    deleteButton: null,
    listItem: null,
    taskField: null,

    init: function() {
        self = this;

        // Init Items
        this.addButton = document.getElementById("add-btn");
        this.deleteButton = document.getElementById("delete-btn");
        this.listItem = document.getElementById("task-item");
        this.taskField = document.getElementById("user-input");

        // Add Button
        this.addButton.addEventListener("click", function() {
            if (self.taskField.value !== '') {
                self.addToList(self.taskField.value);
            }
        });

        this.getList();
    },

    addToList: function(value) {
        let div = document.createElement("div");
        div.textContent = value;
        this.listItem.appendChild(div);
    },

    getList: function() {
        this.get('list', function(data) {
            if (data['result']) {
                for (let i=0;i<data['result'].length;i++) {
                    self.addToList(data['result'][i].title);
                }
            }
        })
    },

    /*addItem: function() {
        console.log("test");

        // Get the Userinput
        let getInput = document.getElementById("user-input").value;
        let taskArray = ["bla bla bla", 1234];

        let newEls = taskArray.push(getInput)

        console.log(newEls);

        let list = document.createElement("li");



        // Attach the Userinput date to the List Items
        list.appendChild(document.createTextNode(getInput));
        let addedItem = listItem.appendChild(list);

        // Show the message box
        let notificationMsg = document.createElement("p");
        let showMsgBox = (document.querySelector(".message-box").style.visibility = "visible");
        let msgSuccess = (document.querySelector(".message-box").textContent = "Task has been added.");
        notificationMsg.appendChild(msgSuccess);


        if (addedItem && getInput) {
            showMsgBox
            msgSuccess
        } else {
            showMsgBox.style.visibility = "hidden";
        }

    },*/

    get: function(path, callback) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                callback(JSON.parse(xhttp.responseText));
            }
        };
        xhttp.open("GET", this.baseUrl + path, true);
        xhttp.send();
    }

}

let todo = new Todo();

(function() {
    todo.init();
})();


// -----------------------------------------


/*

addItem.addEventListener("click", AddItem);

// Erase the given input Data in Input field


removeItem.addEventListener("click", EraseInput);
function EraseInput() {
    let getInput = document.getElementById("user-input").value;
}*/