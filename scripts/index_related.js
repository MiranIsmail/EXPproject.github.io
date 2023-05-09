
function generate_card_wide(input_name,input_date,input_text,input_image,input_id){

    let event_text = input_text
    let event_name = input_name
    let event_date = input_date
    let event_image = input_image
    let event_id = input_id

   // Create a div element for the card
  var cardDiv = document.createElement('div');
  cardDiv.classList.add('card', 'mb-3', 'drop_shadow', "w-75", "mx-auto","border-0");
  cardDiv.style.listStyle = 'none';

  // Create a div element for the row
  var rowDiv = document.createElement('div');
  rowDiv.classList.add('row', 'g-1');

  // Create a div element for the image column
  var imgColDiv = document.createElement('div');
  imgColDiv.classList.add('col-lg-4');

  // Create an img element for the image
  var img = document.createElement('img');
  img.src = event_image;
  img.classList.add('img-fluid', 'rounded_style',"card_image_events");
  img.alt = 'one of our events';

  // Append the image element to the image column
  imgColDiv.appendChild(img);

  // Create a div element for the card body column
  var cardBodyColDiv = document.createElement('div');
  cardBodyColDiv.classList.add('col-lg-8');

  // Create a div element for the card body
  var cardBodyDiv = document.createElement('div');
  cardBodyDiv.classList.add('card-body', 'card_link');

  // Create a h3 element for the card title
  var cardTitle = document.createElement('h3');
  cardTitle.classList.add('card-title', 'title-text');
  cardTitle.textContent = event_name;

  // Create a h5 element for the card text
  var cardText = document.createElement('h5');
  cardText.classList.add('card-text',"card-text-content");
  cardText.textContent = event_date;

  // Create a div element for the text section
  var textDiv = document.createElement('div');
  textDiv.classList.add("card-text-content")

  // Create a p element for the short text
  var shortText = document.createElement('p');
  shortText.textContent = event_text.slice(0,60)+"..."

  // Create a div element for the longer text section
  var moreTextDiv = document.createElement('div');
  moreTextDiv.classList.add('more-text',"card-text-content");
  moreTextDiv.style.display = 'none';


  // Create a p element for the long text
  var longText = document.createElement('p');
  longText.textContent = event_text

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

  // Create a button element for the "go to event" button
  var GoToEvent = document.createElement('button');
  GoToEvent.textContent = 'Go To Event';

  // cardDiv.addEventListener('click', function(){
  GoToEvent.addEventListener('click', function(){
    //sessionStorage.setItem("s_event_id",event_id);
    location.href = '../pages/event_display.php?event_id='+event_id;
  })

  // Append the button element to the card body
  cardBodyColDiv.appendChild(showMoreBtn);
  cardBodyColDiv.appendChild(GoToEvent);

  // Append the image
  // Append the image column to the row
  rowDiv.appendChild(imgColDiv);

  // Append the card body column to the row

  rowDiv.appendChild(cardBodyColDiv);

  // Append the row to the card
  cardDiv.appendChild(rowDiv);

  // Append the card to the document body
  document.getElementById("event_cards_dynamic").appendChild(cardDiv);

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
async function data_load_index(){

  const response = await get_all_event_endpoint()
  const data = await response.json()


  data.forEach((i) => {
    generate_card_wide(i["event_name"], 'Date: '+i["startdate"]+'\n - '+i["enddate"], i["description"], i["eimage"],i["event_id"])
  })
}

async function data_load_index_topten(){

  const response = await get_top_event_endpoint()
  const data = await response.json()

  data.forEach((i) => {
    generate_card_wide(i["event_name"], 'Date: '+i["startdate"]+'\n - '+i["enddate"], i["description"], i["eimage"],i["event_id"])
  })
}

function search_account() {
  // Retrieve all cards
  let input = document.getElementById("search_profile").value;
  location.href = `../pages/profile_display?username=${input}`;
}