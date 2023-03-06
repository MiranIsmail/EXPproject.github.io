function generate_card_wide(input_name,input_date,input_text,input_image){

    let event_text = input_text
    let event_name = input_name
    let event_date = input_date
    let event_image = input_image
  
  // var event_text = "New race courses since 2022. Utö is where the whole swimrun movement started and where the late night bet which became ÖTILLÖ was made. It is an island in the southern part of the Stockholm archipelago almost 90 minutes from Stockholm. This is Swimrun heaven!"
  // var event_name = "ÖTILLÖ SWIMRUN UTÖ"
  // var event_date = "17 JUNE 2023"
  // var event_image = "../images/eventimg/otillo.jpg"
  
   // Create a div element for the card
  var cardDiv = document.createElement('div');
  cardDiv.classList.add('card', 'mb-3', 'drop_shadow', "w-75", "mx-auto");
  cardDiv.style.listStyle = 'none';
  
  // Create a div element for the row
  var rowDiv = document.createElement('div');
  rowDiv.classList.add('row', 'g-1');
  
  // Create a div element for the image column
  var imgColDiv = document.createElement('div');
  imgColDiv.classList.add('col-md-4');
  
  // Create an img element for the image
  var img = document.createElement('img');
  img.src = event_image;
  img.classList.add('img-fluid', 'rounded-start');
  img.alt = '...';
  
  // Append the image element to the image column
  imgColDiv.appendChild(img);
  
  // Create a div element for the card body column
  var cardBodyColDiv = document.createElement('div');
  cardBodyColDiv.classList.add('col-md-8');
  
  // Create a div element for the card body
  var cardBodyDiv = document.createElement('div');
  cardBodyDiv.classList.add('card-body', 'card_link');
  
  // Create a h3 element for the card title
  var cardTitle = document.createElement('h3');
  cardTitle.classList.add('card-title');
  cardTitle.textContent = event_name;
  
  // Create a h5 element for the card text
  var cardText = document.createElement('h5');
  cardText.classList.add('card-text');
  cardText.textContent = event_date;
  
  // Create a div element for the text section
  var textDiv = document.createElement('div');
  
  // Create a p element for the short text
  var shortText = document.createElement('p');
  var shortTextSpan = document.createElement('span');
  shortTextSpan.id = 'short_text';
  shortText.appendChild(shortTextSpan);
  
  // Create a div element for the longer text section
  var moreTextDiv = document.createElement('div');
  moreTextDiv.classList.add('more-text');
  moreTextDiv.style.display = 'none';
  
  // Create a p element for the long text
  var longText = document.createElement('p');
  var longTextSpan = document.createElement('span');
  longTextSpan.id = 'long_text';
  longText.appendChild(longTextSpan);
  
  // Append the short and long text elements to their respective containers
  textDiv.appendChild(shortText);
  moreTextDiv.appendChild(longText);
  
  // Append the text and button elements to the card body
  cardBodyColDiv.appendChild(cardTitle);
  cardBodyColDiv.appendChild(cardText);
  cardBodyColDiv.appendChild(textDiv);
  cardBodyColDiv.appendChild(moreTextDiv);
  
  // Create a button element for the "Show More" button
  var showMoreBtn = document.createElement('button');
  showMoreBtn.classList.add('show-more-btn');
  showMoreBtn.textContent = 'Show More';
  
  // Add an event listener to the "Show More" button to toggle the visibility of the longer text section
  showMoreBtn.addEventListener('click', function() {
    if (moreTextDiv.style.display === 'none') {
      moreTextDiv.style.display = 'block';
      shortText.style.display = 'none';
      showMoreBtn.textContent = 'Show Less';
    } else {
      moreTextDiv.style.display = 'none';
      shortText.style.display = 'block';
      showMoreBtn.textContent = 'Show More';
    }
  });
  
  // Append the button element to the card body
  cardBodyColDiv.appendChild(showMoreBtn);
  
  // Append the image
  // Append the image column to the row
  rowDiv.appendChild(imgColDiv);
  
  // Append the card body column to the row
  
  rowDiv.appendChild(cardBodyColDiv);
  
  // Append the row to the card
  cardDiv.appendChild(rowDiv);
  
  // Append the card to the document body
  document.getElementById("event_cards_dynamic").appendChild(cardDiv);
  document.getElementById("long_text").innerHTML = event_text
  document.getElementById("short_text").innerHTML = event_text.slice(0,60)+"..."
  }

/*---------------------------------------------------------------------------------------------------------------LOADING SEQUENCE */

async function readCSVAndSplitData(filename) {
  const response = await fetch(filename);
  const text = await response.text();
  const rows = text.trim().split('\n');
  const headers = rows[0].split('|');
  const data = [];

  for (let i = 1; i < rows.length; i++) {
    const values = rows[i].split('|');
    const row = {};

    for (let j = 0; j < headers.length; j++) {
      row[headers[j]] = values[j];
    }

    data.push(row);
  }

  return data;
}

/*----------------------------------------------------------------------------------------------------------------LOADING FUNCTION*/
function data_load_index(){
  readCSVAndSplitData('../data_csv/events.csv')
  .then(data => {
    data.forEach((i) => {
      generate_card_wide(i["name"],i["date"],i["description"],i["image_url"])
      console.log(i["name"],i["date"],i["description"],i["image_url"])
  });
  })


  .catch(error => {
    console.error(error);
  });

}