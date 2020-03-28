import 'jquery';
import '../Game/Common';

function showDynamicModal(type, modalStructure)
{
    var modal = '';
    var html = '';

    if(this.available_modal==1)
    {
      this.available_modal=2;
      modal = $('#centeredModal1').modal();
    }
    else
    {
      this.available_modal=1;
      modal = $('#centeredModal2').modal();
    }

    if(this.ajaxError)
    {
      type = "ajaxError";
      modalStructure.title = modals["ajaxerror"].modal.title;  
      modalStructure.text = modals["ajaxerror"].modal.text;  
      modalStructure.image = getModalImageLink(modals["ajaxerror"].modal.image, "common");  
    }    

    switch(type)
    {

    case "levelIntroduced":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'mainTaskIntroduced('+ modalStructure.task +')';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();   

    break;

    }

    case "mainTaskIntroduced":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'continueGame()';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();     

    break;
    }

    case "mainTaskShowed":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    '';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();    

    break;
    }

    case "mainTaskCompleted":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;

    var task_elapsed_time = this.task_end - this.task_start; 
    task_elapsed_time = convertDateToTime(task_elapsed_time);

    html += '<br><br> <h4><i class="fas fa-stopwatch"></i> Čas:</h4>'+ task_elapsed_time;
    html += '<br><br> <h4><a data-toggle="collapse" href="#collapseCode"><i class="fas fa-code"></i> Kód:</a></h4>'
    html += '<div class="collapse" id="collapseCode">';
    html += '<div><code>';
    html += convertCodeForModal();
    html += '</div></code>';
    html += '</div>';
    html += '<br><br> <h4><i class="fas fa-star-half-alt"></i> Hodnotenie:</h4>' + convertRatingToStars();
    modal.find('#modal-text').html(html).end();  



    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'continueGame()';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();   

    break;
    }


    case "mainTaskFailed":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'loadGame()';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Skúsiť znova';
    modal.find('#modal-button').html(html).end();     



    break;
    }

    case "ajaxError":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html = 'window.location.href=\''; 
    html += '{{ url('/')}}' + '\';'; 
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Ukončiť hru';
    modal.find('#modal-button').html(html).end();     



    break;
    }


    case "allMainTasksFinished":
    {

    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;  
    modal.find('#modal-text').html(html).end();  


    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 


    html = 'window.location.href=\''; 
    html += '{{ url('/')}}' + '/start/' + this.category + '/' + (this.level+1) + '\';';    
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Ďalšia úroveň';
    modal.find('#modal-button').html(html).end();    

    break;
    }

    }  

    modal.modal('show'); 
}