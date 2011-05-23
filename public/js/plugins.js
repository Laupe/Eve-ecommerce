// Replacing target=”_blank” for Strict XHTML using JQuery
// source: http://www.badlydrawntoy.com/2009/03/03/replacing-target_blank-for-strict-xhtml-using-jquery-redux/
$(function() {
    $('a[href^=http][rel!=internal]').attr('rel', 'external');

    $('a[rel*=external]').click( function() {
        window.open(this.href);
        return false;
    });
});

// Log wrapper
// usage: log('inside coolFunc',this,arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
    log.history = log.history || [];   // store logs to an array for reference
    log.history.push(arguments);
    if(this.console){
        console.log( Array.prototype.slice.call(arguments) );
    }
};