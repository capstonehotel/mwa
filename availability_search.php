 <form  method="POST" action="index.php?p=booking">
    <div class="container rounded" style="background-color: white; padding: 20px;">
        <div class="col-lg-12">
            <label class="block">
                <h4>Availability Search</h4>
            </label>
        </div>
        <div class="row block" style="display: flex; align-items: center;">
            <div class="col-md-3 col-sm-12 " >
                 <label>Checked in</label> 
                <div style="display: flex; align-items: center;"> 
                <input type="text" data-date="" data-date-format="yyyy-mm-dd" data-link-field="any" 
                                   data-link-format="yyyy-mm-dd"
                                   name="arrival" id="date_pickerfrom"  
                                   value="<?php echo isset($_POST['arrival']) ? $_POST['arrival'] :date('m/d/Y');?>"
                                    class="date_pickerfrom input-sm form-control"
                                    onchange="updateDatePickerToStartDate()" readonly>
                   
                          <span class="input-group-btn" style="margin-left: -30px;">
                              <i class="fa fa-calendar" ></i> 
                          </span>
                      </div>
            </div>
            <div class="col-md-3 col-sm-12 " >
                 <label>Checked out</label>
                 <div style="display: flex; align-items: center;"> 
                <input type="text" data-date=""  data-date-formt="yyyy-mm-dd" data-link-field="any" 
                               data-link-format="yyyy-mm-dd"
                               name="departure" id="date_pickerto"
                               value=""
                               placeholder="mm-dd-yyyy" 
                                       class="date_pickerfrom form-control  input-sm" readonly>
                                         
                          <span class="input-group-btn" style="margin-left: -30px;">
                              <i class="fa fa-calendar" ></i> 
                          </span>
                      </div>
            </div>
            <div class="col-md-3 col-sm-12 " >
                 <label>Person</label>
                 <div style="display: flex; align-items: center;"> 
                <select class=" form-control input-sm " name="person" id="person" style="border-radius: 6px;">
                      <?php $sql ="SELECT distinct(`NUMPERSON`) as 'NumberPerson' FROM `tblroom`";
                         $mydb->setQuery($sql);
                       $cur = $mydb->loadResultList(); 
                          foreach ($cur as $result) { 
                            echo '<option value='.$result->NumberPerson.'>'.$result->NumberPerson.'</option>';
                          }

                      ?>


                      </select> 
                      </div> 
            </div>
            <div class="col-md-3 col-sm-12 " >
                <label></label>
                 <div style="display: flex; align-items: center;"> 
                <button class="btn btn-primary" style="width: 100%;" name="checkAvail" type="submit" id="checkAvail" style="border-radius: 6px;">
                    Check Availability
                </button>
                </div> 
            </div>
        </div>
    </div> 
 </form>
 