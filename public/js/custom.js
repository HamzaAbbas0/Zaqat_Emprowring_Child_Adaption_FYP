// function hide() {
//     var changeTitle = document.getElementById("cardHeader")
//     changeTitle.style.display = "none";

//     var hideText = document.getElementById("givingTreePageText");
//     hideText.style.display = "none";

//     var hideForm = document.getElementById("givingTreeFormPartOne");
//     hideForm.style.display = "none";

//     var displayForm = document.getElementById("givingTreeFormPartTwo");
//     displayForm.style.display = "block"

//     var displayPreviousBTN = document.getElementById("previous")
//     displayPreviousBTN.style.display = "inline-block";

//     var hideNextBTN = document.getElementById("next");
//     hideNextBTN.style.display = "none"

// }

// function revertForm() {
//     var revertTitle = document.getElementById("cardHeader");
//     // revertTitle.innerHTML = "Giving Tree Sign Up";

//     revertTitle.style.display = "block";

//     var revertHideText = document.getElementById("givingTreePageText");
//     revertHideText.style.display = "block";

//     var revertHideForm = document.getElementById("givingTreeFormPartOne");
//     revertHideForm.style.display = "flex";

//     var revertDisplayForm = document.getElementById("givingTreeFormPartTwo");
//     revertDisplayForm.style.display = "none";

//     var showNextBtn = document.getElementById("next");
//     showNextBtn.style.display = "inline-block";

//     var hidePreviousBtn = document.getElementById("previous");
//     hidePreviousBtn.style.display = "none";


// }

function handleCount() {
    var changeTitle = document.getElementsByClassName('ppppppp')
    var removeChildBTN = document.getElementsByClassName('removeChildBTN')

    // handle count of child card
    for (var i = 0; i < changeTitle.length; i++) {
        changeTitle[i].innerHTML = "Child Information " + (i + 1)
    }


    // handle remove btn toggle hide/show
    if (removeChildBTN.length == 1) return removeChildBTN[0].style.display = "none"

    for (var i = 0; i < removeChildBTN.length; i++) {
        removeChildBTN[i].style.display = "inline-block"
    }
}

function cloneForm() {
    var changeTitle = document.getElementsByClassName('ppppppp')
    if (changeTitle.length > 10) return

    // var showRemoveBTN = document.getElementById("removeChildBTN");
    // showRemoveBTN.style.display = "inline-block";
    var duplicateForm = document.getElementById("card-body");
    var clone = duplicateForm.cloneNode(true)
    $(clone).find('input').val('')
    $(clone).find('.labelMessage').html('Age Must Be 0-18')
    $(clone).find('.age-limit').attr('max','18')
    document.getElementById("givingTreeChildForm").append(clone);
    handleCount()
}

function removeChildForm(btn) {
    btn.parentElement.parentElement.parentElement.parentElement.parentElement.remove()
    handleCount()
}