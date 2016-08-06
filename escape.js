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
