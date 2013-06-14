<?
function bcadd($left_operand, $right_operand, $scale=7) {
    @list($ll, $lr) = @explode(".", $left_operand);
    if(is_null($ll)) $ll = "0";
    if(is_null($lr)) $lr = "0";
    $lrlen = strlen($lr);
    @list($rl, $rr) = @explode(".", $right_operand);
    if(is_null($rl)) $rl = "0";
    if(is_null($rr)) $rr = "0";
    $rrlen = strlen($rr);

    /*** right alignment (padding zero) for right numbers ***/
    if($lrlen > $rrlen) $rr = str_pad($rr, $lrlen, "0", STR_PAD_RIGHT);
    else if($rrlen > $lrlen) $lr = str_pad($lr, $rrlen, "0", STR_PAD_RIGHT);
    $origrlen = strlen($lr);

    $left = $ll + $rl;
    $right = $lr + $rr;

    /*** check whether the result of right numbers is carried ***/
    if(strlen($right) > $origrlen) {
        $len = strlen($right)-$origrlen;
        $left = $left + substr($right, 0, $len);
        $right = intval(substr($right, $len));
    }
    $zerolen = $origrlen - strlen($right);

    /*** preserve the scale number digit of the result of right numbers ***/
    if(strlen($right) > ($scale - $zerolen)) $right = round($right, $scale-$zerolen-strlen($right));
    else $right = str_pad($right, $scale-$zerolen, "0", STR_PAD_RIGHT);

    /*** left alignment (padding zero) for the result of right numbers ***/
    if($zerolen > 0) $right = str_pad($right, $scale, "0" ,STR_PAD_LEFT);

    return $left.".".$right;
}

function bcsub($left_operand, $right_operand, $scale=7) {
    @list($ll, $lr) = @explode(".", $left_operand);
    if(is_null($ll)) $ll = "0";
    if(is_null($lr)) $lr = "0";
    $lrlen = strlen($lr);
    @list($rl, $rr) = @explode(".", $right_operand);
    if(is_null($rl)) $rl = "0";
    if(is_null($rr)) $rr = "0";
    $rrlen = strlen($rr);

    /*** right alignment (padding zero) for right numbers ***/
    if($lrlen > $rrlen) $rr = str_pad($rr, $lrlen, "0", STR_PAD_RIGHT);
    else if($rrlen > $lrlen) $lr = str_pad($lr, $rrlen, "0", STR_PAD_RIGHT);
    $origrlen = strlen($lr);

    /*** check whether the result is negtive ***/
    $negtive = false;
    $ill = intval($ll);
    $irl = intval($rl);
    if($ill < $irl) $negtive = true;
    else if($ill === $irl) {
        $ilr = intval($lr);
        $irr = intval($rr);
        if($ilr < $irr) $negtive = true;
        else if($irl === $irr) return "0".str_pad("", $scale, "0");
    }

    /*** if the result is negtive, swap the left and the right ***/
    if($negtive === true) {
        $tmp = $ll;
        $ll = $rl;
        $rl = $tmp;
        $tmp = $lr;
        $lr = $rr;
        $rr = $tmp;
    }

    if(intval($lr) < intval($rr)) {
        $lr = "1".$lr;
        --$ll;
    }
    $left = $ll - $rl;
    $right = $lr - $rr;
    $zerolen = $origrlen - strlen($right);

    /*** preserve the scale number digit of the result of right numbers ***/
    if(strlen($right) > ($scale - $zerolen)) $right = round($right, $scale-$zerolen-strlen($right));
    else $right = str_pad($right, $scale-$zerolen, "0", STR_PAD_RIGHT);

    /*** left alignment (padding zero) for the result of right numbers ***/
    if($zerolen > 0) $right = str_pad($right, $scale, "0" ,STR_PAD_LEFT);

    if($negtive === true) return "-".$left.".".$right;
    else return $left.".".$right;
}

?>
