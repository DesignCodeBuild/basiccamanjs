  var ceCamanControls= Array("brightness", "saturation", "exposure", "gamma", "clip", "stackBlur", "contrast", "vibrance", "hue", "sepia", "noise", "sharpen");

  // Internal function; If no array relating attributes to ids,
  //     we assume that "brightness" is the ID for brightness, etc.
  function ceDefaultControlArray()
  {
    // Define this as some kind of object, instead of an array
    //     That way, we can have strings as indexes like var["index"]
    var ceControlArray = {};
    for(var i=0;i<ceCamanControls.length;++i)
    {
      ceControlArray[ceCamanControls[i]] = ceCamanControls[i];
    }
    return ceControlArray;
  }

  // First, the caman object.
  // Second, an (optional) array that relates the attribute to the id.  
  //     For example, {brightness: "brightrange", saturation: "saturationrange"}
  //     would indicate we're using brightness and saturation, and these
  //     are the corresponding id's to use.
  // ceLabelSuffix is optional; it defaults to "_label"
  // does NOT revert automatically
  function ceUpdateCaman(ceCamanObject, ceCamanControlArray, ceLabelSuffix)
  {
    if( typeof ceCamanControlArray === 'undefined')
      ceCamanControlArray = ceDefaultControlArray();
    if( typeof ceLabelSuffix === 'undefined' )
      ceLabelSuffix = "_label";
    for(var i=0;i<ceCamanControls.length;++i)
    {
      // Only have to update controls that are referenced by the user.
      if(ceCamanControlArray[ceCamanControls[i]] != "")
      {
        // a
        var ceRangeID = ceCamanControlArray[ceCamanControls[i]];
        var ceFilter = ceCamanControls[i];
        var ceValue = $("#" + ceCamanControlArray[ceCamanControls[i]]).val();

        // a
        $("#" + ceCamanControlArray[ceCamanControls[i]] + ceLabelSuffix ).text(ceValue);

        if(ceFilter != "gamma" && parseInt(ceValue) != 0) {
          ceCamanObject[ceFilter](parseFloat(ceValue, 10));
        }
        if(ceFilter == "gamma" && parseInt(ceValue) != 1) {
          ceCamanObject[ceFilter](parseInt(ceValue)+1);
        }
      }
    }
  }

  // 
  function ceResetRanges(ceCamanControlArray, ceLabelSuffix)
  {
    if(ceCamanControlArray === 'undefined')
      ceCamanControlArray = ceDefaultControlArray();
    if(ceLabelSuffix === 'undefined')
      ceLabelSuffix = "_label";
    for(var i=0;i<ceCamanControls.length;++i)
    {
      if(ceCamanControlArray[ceCamanControls[i]] != "")
      {
        $("#" + ceCamanControlArray[ceCamanControls[i]]).val("0");
        $("#" + ceCamanControlArray[ceCamanControls[i]] + ceLabelSuffix ).text("0");
      }
    }
  }


  function ceEscapeString(input)
  {
    var output="";
    for(var i=0;i<input.length;++i)
    {
      if(input.charAt(i) == '/' || input.charAt(i) == ':' || input.charAt(i) == ';'
      || input.charAt(i) == '+' || input.charAt(i) == '=' || input.charAt(i) == '?'
      || input.charAt(i) == '@' || input.charAt(i) == "\\"  || input.charAt(i) == '"'
      || input.charAt(i) == "'" || input.charAt(i) == '!' || input.charAt(i) == '#'
      || input.charAt(i) == '*' || input.charAt(i) == '~' || input.charAt(i) == '^'
      || input.charAt(i) == '(' || input.charAt(i) == ')' || input.charAt(i) == '['
      || input.charAt(i) == ']' || input.charAt(i) == '<' || input.charAt(i) == '>'
      || input.charAt(i) == '{' || input.charAt(i) == '}' || input.charAt(i) == '|'
      || input.charAt(i) == '%' || input.charAt(i) == '&')
      {
        output += "&#" + input.charCodeAt(i) + ";";
      }
      else
      {
        output += input.charAt(i);
      }
    } 
    return output;
  }

//  function ceAjaxSend(actionLocation, redirectLocation, imageData, imageName, imageType, imageDir, imageTitle, imageCaption, imageDescription)
  function ceAjaxSend(actionLocation, dataArray, redirectLocation)
  {

    $.ajax({
      method: "POST", 
      url: actionLocation,
      data: dataArray
      //{data: ceEscapeString(imageData), name: imageName, type: imageType, dir: ceEscapeString(imageDir), title: ceEscapeString(imageTitle), caption: ceEscapeString(imageCaption), description: ceEscapeString(imageDescription)}
    }).done(function(){ 
    if(redirectLocation != "")
      window.location.replace(redirectLocation);
    });

   
 /*
    $("#Jdata").val(dataArray['data']);
    $("#Jtype").val(dataArray['type'])
    $("#Jdir").val(dataArray['tmploc']);
    $("#Jtitle").val(dataArray['title']);
    $("#Jcaption").val(dataArray['caption']);
    $("#Jdescription").val(dataArray['description']);
    $("#testForm").submit(); 
  */
  }
