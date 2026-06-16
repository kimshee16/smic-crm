<?php
                
                $withoutdependenttotalwithoutscholarship = 0;
                $withoutdependenttotalwithscholarship = 0;
                
                $withoutdependentcount = 0;
                foreach ($newprogramoptionsdetails as $row) {
                    if($row->table_category == "Without Dependent Table") { $withoutdependentcount++;
                    }
                }
                
                if($withoutdependentcount > 0) {
                ?>
                <table class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center; background-color: #0d419a; color: #fff;">
                              <th>REQUIREMENTS</th>
                              <th></th>
                              <th colspan="<?php if($schoid != 0){echo "2";}else {echo "1";} ?>">COST</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;">w/o scholarship</th>
                              <?php if($schoid != 0) { ?><th style="width: 25%;">w/ scholarship</th> <?php } ?>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($newprogramoptionsdetails as $row) {
                                      if($row->table_category == "Without Dependent Table") {
                                          
                                        $withoutdependenttotalwithoutscholarship += $row->amount_without_scholarship;
                                        $withoutdependenttotalwithscholarship += $row->amount_with_scholarship;
                                        
                                        if($schoid != 0) { $wss = "<td class='itemwscholarship'>".$row->amount_with_scholarship."</td>"; } else { $wss = ""; }
                                          
                                        echo "<tr style='background-color: #fff !important;'>
                                            <td>".$row->cost_category."</td>
                                            <td>".$row->payment_type."</td>
                                            <td class='itemwoscholarship'>".$row->amount_without_scholarship."</td>
                                            ".$wss."
                                          </tr>";
                                      }
                                    }
                                ?>
                                <tr>
                                    <td>TOTAL (in AUD)</td>
                                    <td></td>
                                    <td id="totalwoscholarship"><?php echo number_format($withoutdependenttotalwithoutscholarship, 2); ?></td>
                                    <?php if($schoid != 0) { ?><td id="totalwscholarship"><?php echo number_format($withoutdependenttotalwithscholarship, 2); ?></td> <?php } ?>
                                </tr>
                            </tbody>
                          </table>
                <?php

                $withoutdependentshowmoneytotalwithoutscholarship = 0;
                $withoutdependentshowmoneytotalwithscholarship = 0;
                
                ?>
                <h5>Showmoney</h5>
                <table class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center; background-color: #0d419a; color: #fff;">
                              <th>REQUIREMENTS</th>
                              <th></th>
                              <th colspan="2">COST</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;">w/o scholarship</th>
                              <?php if($schoid != 0) { ?><th style="width: 25%;">w/ scholarship</th> <?php } ?>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($newprogramoptionsdetails as $row) {
                                      if($row->table_category == "Showmoney Without Dependent Table") {
                                          
                                        $withoutdependentshowmoneytotalwithoutscholarship += $row->amount_without_scholarship;
                                        
                                        if($schoid != 0) { $wss = "<td class='itemwscholarship'>".$row->amount_with_scholarship."</td>"; } else { $wss = ""; }
                                        $withoutdependentshowmoneytotalwithscholarship += $row->amount_with_scholarship;
                                          
                                        echo "<tr style='background-color: #fff !important;'>
                                            <td>".$row->cost_category."</td>
                                            <td>".$row->payment_type."</td>
                                            <td class='itemwoscholarship'>".$row->amount_without_scholarship."</td>
                                            ".$wss."
                                          </tr>";
                                      }
                                    }
                                ?>
                                <tr>
                                    <td>TOTAL (in AUD)</td>
                                    <td></td>
                                    <td id="totalwoscholarship"><?php echo number_format($withoutdependentshowmoneytotalwithoutscholarship, 2); ?></td>
                                    <?php if($schoid != 0) { ?><td id="totalwscholarship"><?php echo number_format($withoutdependentshowmoneytotalwithscholarship, 2); ?></td> <?php } ?>
                                </tr>
                            </tbody>
                          </table>
                <br><br>
                <?php
                }
                
                $withdependenttotalwithoutscholarship = 0;
                $withdependenttotalwithscholarship = 0;
                
                $withdependentcount = 0;
                foreach ($newprogramoptionsdetails as $row) {
                    if($row->table_category == "With Dependent Table") { $withdependentcount++;
                    }
                }
                
                if($withdependentcount > 0) {
                ?>
                <h3>With Dependent</h3>
                <table class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center; background-color: #0d419a; color: #fff;">
                              <th>REQUIREMENTS</th>
                              <th></th>
                              <th colspan="2">COST</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;">w/o scholarship</th>
                              <?php if($schoid != 0) { ?><th style="width: 25%;">w/ scholarship</th> <?php } ?>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($newprogramoptionsdetails as $row) {
                                      if($row->table_category == "With Dependent Table") {
                                          
                                        if($schoid != 0) { $wss = "<td class='itemwscholarship'>".$row->amount_with_scholarship."</td>"; } else { $wss = ""; }
                                        
                                        $withdependenttotalwithoutscholarship += $row->amount_without_scholarship;
                                        $withdependenttotalwithscholarship += $row->amount_with_scholarship;
                                          
                                        echo "<tr style='background-color: #fff !important;'>
                                            <td>".$row->cost_category."</td>
                                            <td>".$row->payment_type."</td>
                                            <td class='itemwoscholarship'>".$row->amount_without_scholarship."</td>
                                            ".$wss."
                                          </tr>";
                                      }
                                    }
                                ?>
                                <tr>
                                    <td>TOTAL (in AUD)</td>
                                    <td></td>
                                    <td id="totalwoscholarship"><?php echo number_format($withdependenttotalwithoutscholarship, 2); ?></td>
                                    <?php if($schoid != 0) { ?><td id="totalwscholarship"><?php echo number_format($withdependenttotalwithscholarship, 2); ?></td><?php } ?>
                                </tr>
                            </tbody>
                          </table>
                <?php
                
                $withdependentshowmoneytotalwithoutscholarship = 0;
                $withdependentshowmoneytotalwithscholarship = 0;
                
                ?>
                <h5>Showmoney</h5>
                <table class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center; background-color: #0d419a; color: #fff;">
                              <th>REQUIREMENTS</th>
                              <th></th>
                              <th colspan="2">COST</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;">w/o scholarship</th>
                              <?php if($schoid != 0) { ?><th style="width: 25%;">w/ scholarship</th> <?php } ?>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($newprogramoptionsdetails as $row) {
                                      if($row->table_category == "Showmoney With Dependent Table") {
                                          
                                        $withdependentshowmoneytotalwithoutscholarship += $row->amount_without_scholarship;
                                        
                                        if($schoid != 0) { $wss = "<td class='itemwscholarship'>".$row->amount_with_scholarship."</td>"; } else { $wss = ""; }
                                        $withdependentshowmoneytotalwithscholarship += $row->amount_with_scholarship;
                                          
                                        echo "<tr style='background-color: #fff !important;'>
                                            <td>".$row->cost_category."</td>
                                            <td>".$row->payment_type."</td>
                                            <td class='itemwoscholarship'>".$row->amount_without_scholarship."</td>
                                            ".$wss."
                                          </tr>";
                                      }
                                    }
                                ?>
                                <tr>
                                    <td>TOTAL (in AUD)</td>
                                    <td></td>
                                    <td id="totalwoscholarship"><?php echo number_format($withdependentshowmoneytotalwithoutscholarship, 2); ?></td>
                                    <?php if($schoid != 0) { ?><td id="totalwscholarship"><?php echo number_format($withdependentshowmoneytotalwithscholarship, 2); ?></td><?php } ?>
                                </tr>
                            </tbody>
                          </table>
                    <br><br>
                <?php
                }
                
                $subsequenttotalwithoutscholarship = 0;
                $subsequenttotalwithscholarship = 0;
                
                $subsequentcount = 0;
                foreach ($newprogramoptionsdetails as $row) {
                    if($row->table_category == "Subsequent Table") { $subsequentcount++;
                    }
                }
                
                if($subsequentcount > 0) {
                ?>
                <h3>Subsequent</h3>
                <table class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center; background-color: #0d419a; color: #fff;">
                              <th>REQUIREMENTS</th>
                              <th></th>
                              <th colspan="2">COST</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;">w/o scholarship</th>
                              <?php if($schoid != 0) { ?><th style="width: 25%;">w/ scholarship</th> <?php } ?>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($newprogramoptionsdetails as $row) {
                                      if($row->table_category == "Subsequent Table") {
                                          
                                        $subsequenttotalwithoutscholarship += $row->amount_without_scholarship;
                                        $subsequenttotalwithscholarship += $row->amount_with_scholarship;
                                        
                                        if($schoid != 0) { $wss = "<td class='itemwscholarship'>".$row->amount_with_scholarship."</td>"; } else { $wss = ""; }
                                          
                                        echo "<tr style='background-color: #fff !important;'>
                                            <td>".$row->cost_category."</td>
                                            <td>".$row->payment_type."</td>
                                            <td class='itemwoscholarship'>".$row->amount_without_scholarship."</td>
                                            ".$wss."
                                          </tr>";
                                      }
                                    }
                                ?>
                                <tr>
                                    <td>TOTAL (in AUD)</td>
                                    <td></td>
                                    <td id="totalwoscholarship"><?php echo number_format($subsequenttotalwithoutscholarship, 2); ?></td>
                                    <?php if($schoid != 0) { ?><td id="totalwscholarship"><?php echo number_format($subsequenttotalwithscholarship, 2); ?></td><?php } ?>
                                </tr>
                            </tbody>
                          </table>
                <?php
                
                $subsequentshowmoneytotalwithoutscholarship = 0;
                $subsequentshowmoneytotalwithscholarship = 0;
                
                ?>
                <h5>Showmoney</h5>
                <table class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center; background-color: #0d419a; color: #fff;">
                              <th>REQUIREMENTS</th>
                              <th></th>
                              <th colspan="2">COST</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;"></th>
                              <th style="width: 25%;">w/o scholarship</th>
                              <?php if($schoid != 0) { ?><th style="width: 25%;">w/ scholarship</th> <?php } ?>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($newprogramoptionsdetails as $row) {
                                      if($row->table_category == "Showmoney Subsequent Table") {
                                          
                                        $subsequentshowmoneytotalwithoutscholarship += $row->amount_without_scholarship;
                                        $subsequentshowmoneytotalwithscholarship += $row->amount_with_scholarship;
                                        
                                        if($schoid != 0) { $wss = "<td class='itemwscholarship'>".$row->amount_with_scholarship."</td>"; } else { $wss = ""; }
                                          
                                        echo "<tr style='background-color: #fff !important;'>
                                            <td>".$row->cost_category."</td>
                                            <td>".$row->payment_type."</td>
                                            <td class='itemwoscholarship'>".$row->amount_without_scholarship."</td>
                                            ".$wss."
                                          </tr>";
                                      }
                                    }
                                ?>
                                <tr>
                                    <td>TOTAL (in AUD)</td>
                                    <td></td>
                                    <td id="totalwoscholarship"><?php echo number_format($subsequentshowmoneytotalwithoutscholarship, 2); ?></td>
                                    <?php if($schoid != 0) { ?><td id="totalwscholarship"><?php echo number_format($subsequentshowmoneytotalwithscholarship, 2); ?></td><?php } ?>
                                </tr>
                            </tbody>
                          </table>
                    <br><br><br>
                <?php
                }
                ?>
                <!-- <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Others</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($programoptions as $row) {
                              echo "<tr>
                                <td>".$row->others."</td>
                              </tr>";
                            }
                            ?>
                            </tbody>
                          </table>
                <br> -->