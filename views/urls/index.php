


<style type="text/css">
        label{
          padding-top: 7px; 
        }

        #url-list{
          overflow: scroll;
          height: 200px;
        }
</style>



<div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default" style="padding:10px">
          <div class="panel-body">
              <form method="post" action="/-middleware_SMC/?controller=urls&action=add" class="form-horizontal">
                <div class="form-group">
                  <label for="input_url" class="col-md-3">Endpoint URL</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" id="input_url" placeholder="Enter the Endpoint URL here .." name="url">
                  </div>
                </div>
                <div class="form-group">
                  <label for="shortname" class="col-md-3">Short Name</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" id="shortname" placeholder="Something to remember the url .." name="shortname">
                  </div>
                </div>
                <div class="form-group">
                  <label for="description" class="col-md-3">Description</label>
                  <div class="col-md-9">
                  <textarea id ="description" class="form-control" rows="3" placeholder="Description of the URL" name="description"></textarea>
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label for="shortname" class="col-md-3"></label>
                  <div class="col-md-9">
                  <button type="submit" class="btn btn-default">Add</button>
                  </div>
                </div>
                
              </form>
              
          </div>
        </div>
        </div>
      </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="well">
        <div class="list-group" id="url-list">
          <?php 
            
            foreach ($urls as $url) {
          ?>
          <a href="/-middleware_SMC/?controller=urls&action=show&id=<?php echo $url->id; ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $url->url;?></h4>
            <p class="list-group-item-text"><?php echo $url->shortname;?></p>
            <p class="list-group-item-text"><?php echo $url->des;?></p>
          </a>
            <?php } 
            ?>
          
        </div>
        </div>
      </div>
    </div>