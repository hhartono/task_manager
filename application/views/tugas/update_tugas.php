    <form action="/tugas/update_status_selesai" method="post">
        <div class="da-form-inline">
            <div class="da-form-row">
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Project</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
        <?php foreach ($tugas as $tugas) { ?>
        
                <tr>
                    <td><?php echo $tugas['worker']; ?></td>
                    <td><?php echo $tugas['project']; ?></td>
                    <td><?php echo $tugas['deskripsi']; ?></td>
                    <input type="hidden" name="task_id" value="<?php echo $tugas['task_id'];?>">
                    <?php if($tugas['tanggal_selesai'] != 0){ ?>
                    <td><td><?php echo $tugas['tanggal_selesai']; ?></td></td>
                    <?php }else{ ?>
                    <td><input type="submit" class="finish btn btn-danger" value="Selesai"></td>
                    <?php } ?>
                </tr>
            </table>                
            </div>

            <?php } ?>
        </div>
    </form>