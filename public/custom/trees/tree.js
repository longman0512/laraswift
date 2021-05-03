function calculateCoin() {
    console.log(document.getElementById("quantity").value)
    document.getElementById("coin").value = document.getElementById("quantity").value * 1000;
}
function updateShareStatus(value){
    $("#share_status").val(value);
}
function validateForm() {
    var latitude = $("#latitude").val();
    var longitude = $("#longitude").val()
    var quantity = $("#quantity").val();
    var coin = $("#coin").val();
    var variety = $("#variety").val();
    var caption = $("#caption").val();
    
    console.log(latitude, longitude, quantity, coin, variety);
    if(Number(quantity) < 1){
        console.log("error", quantity);
        notify('Quantity must be greater than 0','error');
        return false;
    } else if (!latitude || !longitude) {
        notify('You have to select the coords on Map','error');
        return false;
    } else if (!coin) {
        notify('Quantity must be greater than 0','error');
        return false;
    } else if (!variety) {
        notify('Can\'t insert without Variety','error');
        return false;
    } else if (!caption) {
        notify('Please insert caption','error');
        return false;
    }
    return true;
}
calculateCoin();
