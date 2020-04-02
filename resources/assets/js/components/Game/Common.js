import * as $ from 'jquery';

function convertRatingToStars(rating)
{
	var result = '';
	for(var i=0; i < rating; i++)
	{
		result += '<i class="fas fa-star" style="color:#F9C10A"></i>';     
	}

	return result;
}

function convertCodeForModal(code)
{

	var result = '';
	for(var i=0; i < code.length; i++)
	{
		result += code[i] + '<br>';     
	}

	return result;
}

function getModalImageLink(imageType, location)
{
	var modalImageUrl = new URL('game');    

	if(location==='level')
	{
		return modalImageUrl + '/' + this.category + 'x' + this.level + '/' + imageType + '.png';
	}
	else
	{
		return modalImageUrl + '/' + 'common' + '/' + imageType + '.png';
	}
}

function convertDateToTime(dateToConvert)
{

	function addZero(i) {
		if (i < 10) {
			i = '0' + i;
		}
		return i;
	}

	var date = new Date(dateToConvert);

	var h = addZero(date.getUTCHours());
	var m = addZero(date.getUTCMinutes());
	var s = addZero(date.getUTCSeconds());
	var hms = h + ':' + m + ':' + s;
	return hms;

}

function rateMainTaskCompletion(object)
{
	let rating = 0;
	var task = 'mainTask' + object.currentMainTask;

	var isCorrect = true;
	var mistakeCount = 0;
	var playerSolution = String(object.commandArray);      
	playerSolution = playerSolution.split(',');
	// this.code = playerSolution.slice();  
	
	const ratings = {}; //TO DO: get ratings

	var solution = ratings[task].solution;
	solution = solution.split(',');

	//if there are any rules check if the solution passes 
	if(ratings[task].hasOwnProperty('rules'))
	{        
		var ruleType;
		var rulesCount = Object.keys(ratings[task].rules).length;
    
		var ruleCount = 0;
		var actualCount = 0;    

		for (var j=0; j<rulesCount;j++)
		{              
			if(j>0 && !isCorrect)
			{
				break;
			}

			this.ruleError = j;

			actualCount = 0;

			ruleType = ratings[task].rules[j].blocks.split(',');                       
        
			ruleCount = ratings[task].rules[j].count;

			isCorrect = false;

			for(var k in ruleType)
			{
        
				if(actualCount<ruleCount)
				{
					for(var l in playerSolution)
					{
						if(playerSolution[l].startsWith(ruleType[k]))
						{
            
							actualCount++;
        
							if(actualCount==ruleCount)
							{
								isCorrect = true;    
								break;
							}
						}
					}
				}

			}


		}       
    
	}   


	if(playerSolution.length==solution.length) //player's solution has same length as defined solution, but the order of blocks could be different
	{      
		var index = -1;

		for(var h=0; h<solution.length; h++)
		{

			index = -1;
        
			for(var i=0; i<playerSolution.length; i++)
			{

				if(playerSolution[i]==solution[h])
				{             
					index = i;
					break;
				}            

			}

			if(index != -1)
				playerSolution.splice(index, 1);
			else
				mistakeCount++;

		}                 
    
		if(mistakeCount < 4)
			rating = 5 - mistakeCount;
		else
			rating = 1;       


	}
	else //player's solution has different length than defined solution
	{

		if(playerSolution.length > solution.length)
		{
            
			mistakeCount = + playerSolution.length - solution.length;
            
			if(mistakeCount < 4)
				rating = 5 - mistakeCount;
			else
				rating = 1;


		}
		else
		{
			rating = 5;
		}

	}

	if(isCorrect) 
	{   
		return rating; 
	}
	else
	{ 
		rating = 0;
		return rating;
	}     

}

function sendRequest(request) 
{
	return new Promise((success, error) => {
		$.ajax({
			headers: request.headers,
			method: request.method, 
			url: request.url, 
			data: request.data,
			success: (response) => { 
				console.log('RequestManager RESPONSE', response);
				return success(response);
			},
			error: (textStatus, errorThrown) => {
				console.log('RequestManager error: ' + textStatus + ' : ' + errorThrown);
				return error();
			}
		});
	});
}

export { convertRatingToStars, convertCodeForModal, getModalImageLink, convertDateToTime, rateMainTaskCompletion, sendRequest };