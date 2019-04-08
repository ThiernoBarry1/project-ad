 // gerer l'ajout d'une image lors qu'on clique sur le button
 $('#ad-image').click(function(){
    // je recupère le numero des futurs champs!
    const index  = +$('#widget-counter').val();
    // je recupère mon prototype des  entrés encore il faut inpecter le champ du formulaire
    const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g,index);
    // j'injecte ce code au sein de la div
    $('#annonce_images').append(tmpl);
    $('#widget-counter').val(index+1);
   // gerer la suppression du boutton 
   handleDeleteButtons();
 });
 function handleDeleteButtons()
 {   // lorsqu'on clique sur le button delete (X)
     $('button[data-action="delete"]').click(
         function(){
             const target  = this.dataset.target;
             $(target).remove();
         }
     )
 }
 function udateCounter(){
     // la mise a jour du compteur
     const count = +$('#annonce_images div.form-group').length;
     $('#widget-counter').val(count);
 } 
 udateCounter();
 handleDeleteButtons();