import * as $ from 'jquery';
function sendRequest(request) 
{
    return new Promise = (success,error) => { 
    $.ajax({
        headers: request.headers,
        method: request.method, 
        url: request.url, 
        data: request.data,
        success: (response) => { 
            console.log("RequestManager RESPONSE", response);
            return success(response);
        },
        error: (textStatus, errorThrown) => {
            console.log("RequestManager error: " + textStatus + ' : ' + errorThrown);
            return error();
        }
    });
    }
}
export default { sendRequest }