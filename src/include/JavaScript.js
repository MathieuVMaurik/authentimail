var counter = 1;

function AltEmailInputAdd()
{
    var TestMail = document.getElementById('AltEmail['+counter+']').value;
    if(TestMail.indexOf('@')>0) {

        counter++;
        var NewDiv = document.createElement('p');
        NewDiv.innerHTML = '<label for="AltEmail['+ counter +']">Alternative E-mail</label> <input type="text" id="AltEmail['+ counter +']" name="AltEmail['+ counter +']" />';

        document.getElementById("InputDiv").appendChild(NewDiv);
        document.getElementById("errorbox").innerHTML = "";
    }
    else
    {
        document.getElementById("errorbox").innerHTML = "Rekt no mail bro";
    }

}