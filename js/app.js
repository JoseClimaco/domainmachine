/**
 * Created by josec on 19/09/2014.
 */

function toggle(source) {
    checkboxes = document.getElementsByName('options[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
}