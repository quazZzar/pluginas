<form action="make.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8" target="_blank">
Template:
<select name="typ">
  <option value="ss-ticket">Social Security</option>
  <option value="ss-ticket-runestad">Social Security - Runestad</option>
  <option value="ss-ticket-pruemm">Social Security - Pruemm</option>
  <option value="ss-ticket-crmyers">Social Security - CR Myers</option>
  <option value="ss-ticket-nolan">Social Security - Marc Nolan</option>
  <option value="ss-ticket-fort">Social Security - Justin Fort</option>
  <option value="ss-ticket-bclark">Social Security - Brad Clark</option>
  <option value="ss-ticket-mnolan">Social Security - Marc Nolan</option>
  <option value="ss-ticket-hill">Social Security - Dan Hill</option>
  <option value="ss-ticket-lee">Social Security - Oliver Lee</option>  
   <option value="ss-ticket-rongue">Social Security - Ron Guevarra</option>
  <option value="ss-ticket-nickmag">Social Security - Nick Maggard</option>
<option value="ss-ticket-jklau">Social Security - Jeff Klauenberg</option>  
  <option value="ira-ticket">IRA</option>
  <option value="ira-ticket-speir">IRA - Jim Speir</option>
  <option value="ira-ticket-oray">IRA - Greg Oray</option>
  <option value="ira-ticket-runes">IRA - Ric Runestad</option>   
  <option value="ira-ticket-fort">IRA - Justin Fort</option>
  <option value="ira-ticket-nickmag">IRA - Nick Maggard</option>
  <option value="ira-ticket-q-pearcy">IRA - Quince Pearcy</option>
  <option value="ira-ticket-npetersn">IRA - Nick Peterson</option> 
  <option value="ira-ticket-nolan">IRA - MarC Nolan</option>
  <option value="ira-ticket-sha">IRA - Neel Sha</option>
</select>
<br><br>

Agent Name: <input type="text" name="agent-name" value="" /><br><br>
Practice Name: <input type="text" name="practice-name" value="" /><br>
Agent Address 1: <input type="text" name="agent-address-1" value="" /><br>
Agent Address 2: <input type="text" name="agent-address-2" value="" /><br>
Agent City/State/ZIP: <input type="text" name="agent-city" value="" /><br>
Agent Phone: <input type="text" name="agent-phone" value="" /><br><br>

Workshop Venue: <input type="text" name="workshop-venue" value="<? echo $_POST['workvenu']; ?>" /><br>
Workshop Room: <input type="text" name="workshop-room" value="" /><br>
Workshop Address 1: <input type="text" name="workshop-add1" value="<? echo $_POST['workaddr']; ?>" /><br>
Workshop Address 2: <input type="text" name="workshop-add2" value="" /><br>
Workshop City/State/ZIP: <input type="text" name="workshop-city" value="<? echo $_POST['workcity']; ?>" /><br>
<input type="file" name="csv" value="" />
<input type="submit" name="submit" value="Save" /></form>