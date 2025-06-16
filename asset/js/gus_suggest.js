$(document).ready(function() {
    $.fn.autosugguest({  
           className: 'ajak_suggest',
          methodType: 'POST',
            minChars: 1,
              rtnIDs: true,
            dataFile: base_url + index_page + 'p/autosuggest'
    });
});