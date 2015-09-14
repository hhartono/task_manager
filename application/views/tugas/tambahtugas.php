    <form action="/tugas/set_tugas" method="post">
        <div class="da-form-inline">
            <div class="da-form-row">
                <label class="da-form-label">Project</label>
                <div class="da-form-item large">
                    <select name="project" class="form-control m-bot15">
                        
                        <?php 
                        if(isset($project)){
                        ?>
                            <option value="">Select Project</option>
                        <?php
                            foreach ($project as $row){
                        ?>
                            <option value="<?php echo $row->id;?>"><?php echo ucwords($row->nama_project);?></option>
                        <?php
                            }
                        }else{
                        ?>
                            <option value="">----------------</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="da-form-row">
                <label class="da-form-label">Worker</label>
                <div class="da-form-item large">
                <?php
                   if(isset($worker)){ 
                        foreach ($worker as $worker){ 
                    ?>
                        <input type="checkbox" name="worker[]" value="<?php echo $worker->id;?>"> <?php echo $worker->nama;?><br/>  
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="da-form-row">
                <label class="da-form-label">Deskripsi</label>
                <div class="da-form-item large">
                    <textarea name="deskripsi"></textarea>
                </div>
            </div>
            <div class="da-form-row">
                <label class="da-form-label">Keterangan</label>
                <div class="da-form-item large">
                    <textarea name="keterangan"></textarea>
                </div>
            </div>

            <input type="submit" class="finish btn btn-danger" value="Proses">
        </div>
    </form>