const msg = document.querySelector("[data-removable]");
const db_phone = document.querySelector("[db-phone]");

if (msg) {
  setTimeout((_) => {
    msg.remove();
  }, parseInt(msg.dataset.removeAfter) * 1000);
}

const ch1 = document.getElementById('fb');
const ch2 = document.getElementById('mb');

if (db_phone) {
  const usedb = db_phone.dataset.db;
  if(usedb == 'both'){
    ch1.checked = true;
    ch2.checked = true;
  }
  else if(usedb == "Maria"){
    ch1.checked = false;
    ch2.checked = true;
  }
  else{
    ch1.checked = true;
    ch2.checked = false;
  }
}

if(ch1){
  ch1.addEventListener('change', function() {
    updateCheckboxes(ch1, ch2);
  });

  ch2.addEventListener('change', function() {
    updateCheckboxes(ch2, ch1);
  });
}


function updateCheckboxes(clickedCheckbox, otherCheckbox) {
  if(!clickedCheckbox.checked && !otherCheckbox.checked){
    clickedCheckbox.checked = true;
    otherCheckbox.checked = true;
  }
}

// addaptive work-area background height
const workArea = document.getElementById("wa");
console.log(workArea);
let x = workArea.scrollHeight;
let m = window.innerHeight - 60;
let meh = x > m ? x : m;
console.log("x: ", x, "m: ", m, "meh: ", meh);
