function formatToCurrency(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function cleanCurrencyFormat(nStr)
{
    return parseFloat(nStr.replace(/,/g,''));
}

$(document).ready(function()
{
    $('.currency').each(function()
    {
        var formattedValue = formatToCurrency($(this).text());
        $(this).text(formattedValue);
    });
    
});