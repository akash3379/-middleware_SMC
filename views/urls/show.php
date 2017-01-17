
<div class="row">
    <div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="text-primary"><?php echo $url_data->url ?></span><span class="pull-right text-warning">Shortname: <?php echo $url_data->shortname; ?></span></h3>
        </div>
        
        <div class="panel-body" style="overflow:scroll;height:80vh">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php 
            
            foreach ($mappings as $mapping) {
                
             ?>    
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $mapping->id; ?>">
                    <span class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $mapping->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $mapping->id; ?>">
                        <?php echo $mapping->des; ?>
                        </a>
                    </span>
                    <span class="pull-right"><a href="/-middleware_SMC/?controller=mappings&action=use_mapping&id=<?php echo $mapping->id; ?>">Use it</a></span>
                    </div>
                    <div id="collapse<?php echo $mapping->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $mapping->id; ?>">
                    <div class="panel-body">
                        
                        <div class="col-md-7 well">
                            <?php 
                            foreach ($mapping->map as $param_name => $dept_col) {
                                
                             ?>
                             <p><span class="text-primary"><?php echo $param_name; ?></span> => <?php echo $dept_col[0]; ?> -> <?php echo $dept_col[1]; ?> </p>
                            <?php } ?>
                        </div>
                        <div class="col-md-1">
                        </div>

                        <div class="col-md-4 well">
                            <p><span class="text-primary">Created On:</span> <?php echo date("jS M Y G:i ",strtotime($mapping->created_on)); ?> </p>
                            <p><span class="text-primary">Created By:</span> <?php echo $mapping->created_by; ?> </p>
                            <p><span class="text-primary">Edited On:</span> <?php echo date("jS M Y G:i ",strtotime($mapping->modified_on)); ?> </p>
                            <p><span class="text-primary">Edited By:</span> <?php echo $mapping->modified_by; ?> </p>
                        </div>

                    </div>
                    </div>
                </div>

            
            <?php } ?>
            </div>
        </div>
        
    </div>
    </div>
<script type="text/javascript">
        function add_fields()
        {
            var ndiv=document.createElement('div');
            
            ndiv.innerHTML="<div class='row'><div class='col-md-4'><select class='form-control' name='para[]'><?php foreach($param_list as $param){ ?><option value='<?php echo $param ?>'><?php echo $param ?></option><?php } ?></select></div><div class='col-md-4'><select class='form-control' name='table[]'> <?php foreach($table_list as $table){ ?><option value='<?php echo $table ?>'><?php echo $table ?></option><?php } ?></select></div></div>";
            document.getElementById("ff").appendChild(ndiv);

        }
    </script>
    <div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Add new mapping</h3>
        </div>
        
        <div class="panel-body" style="overflow:scroll;height:80vh">
            <!--===================== Form starts here ========================= -->
            <form method="post" action="/-middleware_SMC/?controller=mappings&action=add">

                <input type="hidden" value="<?php echo $mapping->url?>" name="url[]">                
                <div id="ff">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control" name="para[]">
                            <?php foreach($param_list as $param){ ?>
                            <option value="<?php echo $param; ?>"><?php echo $param; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="dept_select" name="table[]">
                            <?php foreach($table_list as $table){ ?>
                            <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                    
                </div>

                <div class="row">
                    <input type="button" value="Add Another" class="btn btn-default" onClick="add_fields()">
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>

            </form>
            <!-- ============================================================== -->
        </div>
        
    </div>
    </div>
</div>
<script>

    
</script>