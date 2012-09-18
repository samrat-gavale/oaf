<script type="text/javascript">

function is_selected_enable(to_enable_element, check_element)
{
if(document.getElementById(check_element).checked==true)
{
document.getElementById(to_enable_element).disabled=false;
}
}

function is_selected_disable(to_disable_element, check_element)
{
if(document.getElementById(check_element).checked==true)
{
document.getElementById(to_disable_element).disabled=true;
}
}

</script>
