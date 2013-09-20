<HTML>
<HEAD>
</HEAD>
<BODY>

<p>CDR Has been imported. Import Details are shown below.</p>



<TABLE width="300" cellpadding="5" cellspacing="2">
    <TR>
        <TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">CDR Date</TH>
        <TD><?php echo date("d/m/Y", strtotime($cdrDate)); ?></TD>
    </TR>
    <TR>
        <TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">Calls Made</TH>
        <TD><?php echo number_format($callsMade,0); ?></TD>
    </TR>
    <TR>
        <TH width="50%" style="text-align: right; background-color: #EEEEEE; border-right: #CCCCCC 1px solid;">Total Cost</TH>
        <TD>&pound;<?php echo number_format((ceil($totalCost*100)/100),2); ?></TD>
    </TR>
</TABLE>


</BODY>
</HTML>