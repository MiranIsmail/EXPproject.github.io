function search_event() {
    var url = "http://193.11.187.227:5000/account";
    var params = "email=a@a&password=dsf";
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);

    //Send the proper header information along with the request


    xhr.send(params);
};

function sayHello() {
    search_event()
    return Word.run((context) => {
        // insert a paragraph at the start of the document.
        const paragraph = context.document.body.insertParagraph(
            'Hello World',
            Word.InsertLocation.start
        );

        // sync the context to run the previous API call, and return.
        return context.sync();
    });
};