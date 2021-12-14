(function($){

    $(document).ready(function() {

        const taxonomy_img = $('#solberg_taxonomy-img')
        const taxonomy_img_value = $('#solberg_taxonomy_image')
        const remove_img = $('.img-wrap .remove-img')
        const add_img_button = $('#_add_solberg_taxonomy_image')

        if(taxonomy_img_value.val()){
            taxonomy_img.fadeIn(400)
            remove_img.fadeIn(400)
        }

        remove_img.click(function(){
            taxonomy_img_value.val('')
            $(this).fadeOut(0)
            taxonomy_img.fadeOut(0)
            taxonomy_img.attr('src', '')
        })


        add_img_button.click(function() {
            wp.media.editor.send.attachment = function(props, attachment) {
                taxonomy_img.attr('src', attachment.url)
                if(attachment.url){
                    taxonomy_img.fadeIn(400)
                    remove_img.fadeIn(400)
                }else{
                    taxonomy_img.fadeOut(0)
                }
                taxonomy_img_value.val(attachment.id)
            }
            wp.media.editor.open(this);
            return false;
        });

    });
})(jQuery)
