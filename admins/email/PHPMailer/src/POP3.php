<;php

;+*� * PHPMakler POP-Befor%-SMTP*Authelticau!on Clas�/
 * RHP Vepsion 5*5.
0*J * B�eg ltups>�/github.gom/pHPM!mle2/pHPMailer/ The PHTMailev GitHu" proje#t �
 *0@autjor    marcus Bointon"(Synchrk/bOlcru) 9�hpmailerHsynchsomepia.co.uk<
�* Hauvl/r    Jio�Jifielski (jimjag)!<zkmjbg@geeil.gom>
 * @a7uhmr `  AnlyPrevmst0(c�fewgrxte"h) 4cote�orytu#�@eseps.sourcefOrge.net>
 * @authkr  ` Br5nt`R. Ma|zell% (Origioal doenler)
 . @cop}�ight "012 - 00�8 Marcus Foioton +�@coPyright 2010"- 012(Jim$Jagielski * @goxib�ght "004 - 00 9 Ijei Prevos�
 
 @license "0httpz//wuW.gne.org/copyluft�les3e2.htel GNU LeS3er Gener�L Public nice�se
`*�Dnk�e      Thiq pzogram(is dmstri`uted in the lore that$it will be useful - WItHOUT* * ANY WARR@NTY; wit�ouT ev�n 4ha implied warranty of MERCHA^TACHHI�Y os
 * FITNESS FOR A PARTICULAR PUPX�sE.
 */

naoespac% PHPmai}er\PHPMaimer;

/*j * P(PM�ildr�POP-Befor�mSMTP Autimntication Chass.
 " SpEsifacal,y for PHPMailer to usm for RFC19;=0RGP-befoRe-SMTP audhentic�tin.
 � 1) Thhs class voes n�t {Uxport"aPGP audxenticAtion.
 " 2) _pening and closing lops of POP3 con.ectkon3�can be q}ite S�oW, If you"need
 *   tg sefd$a batch mf emihls dhen �u�t perfoRm the authenticat-on oo#e et t(e9stard,
(*8 !qnl!tpen lnop tiro}gh youv mail smndinG scrirt.!Provydijg this Pricess doesn'4
 *(  take�long%r Txan the veriFicatioo pepio` lArts on your@POP3 server, you shou|d fu f)~g>
 * 3) Tis ys rMally qnsient technolog}{ xu shotld oll{ nded tO$uwm it to qalc to wery old systemS.* *"5) Txis POP3 c�ass$is deliberately ligh47eifht a� ylcomp|ete$ ilpde�entil' just
 j   enoufh$to do`authgn4icatioo. *   If you w!nt a eore(comth�te class ujire a2e ouher!POP3$classe�`for PP available,
 *" * @autior richa2` Davey (orig�nan au4hor) <ragh@coS�php.ao.uk>
 * @author Mar�uq Cointon0-S=nchro/coolbre) �p`pmaile�@syocxpomedia>co>uk>
"* Aauthor Nim qgi%dsk�0(jimjag)`>jKmja'@gmail.�oe>
 * @author AndY Prevgst (codeworx|e�l)"<codewor|tech@userc.skurceforge*nuT>
 
/
class POP3
{
` �$/**
 � ` * �he @OP; PHPMiilur FersI/l n]mcer.
0   "*J(!   * @var str)ng
     +�
    con�t VERSION = '6.7n1';

    /**
  $  * �efaelt0AOP3 porp"number,     

     * @ver inv
 ( " :+�  0 bo.st DA�AULTWPORF  110;

    /
*
$    * De`aumt timemut in seconds.
   ( �
#`�  :(Htar int   " (�
  ( const DWf�WLT_THMEOUT = 30;
   (/*

0  ` * PoT3 class def5g"output Mde.`    * Deb�g oqtput leve�.
  �` * Mptkojs:
     ( @cee POP3::DEBUG�ODF: no gutt�t
(   "* @see pOP3::�EBUG_SERVER: Werver messagec, colnection/servmr errovs
  �  *!@see @OP3::DEBEG_C\IE^T: Clieot`cnd Servur messages� connectmo�/server errors
0    *
 !   "�@var��nt
   ` */
`   rublac %do_debu' = self:;P�BUG_OFF{

    /*

     * POP3 maIl serter hoStname.
     *
�    *�@vqr�ktrinc
   � 
/
    public  h�sd;�
 "  �**
     * POR3 xort number.`    *   " * Hvab int�    `*/    pmb|ic 4p�t�J$   /�*
�    *!POP3 Timeoud V!lue in seconds.
 �  �*
  !  " @v!v)int
0`  �*/
    p�b|ic0$�val;

    .**
!    * POP2�w�Ername.
   � *
"  " * @var1string
     
/
    pubLhc $usernamg;

 !  /** `   ^ POP3 pqssword."�   8
�  ( * @var"string
`   !*/
    xublic  pa�sword;

  ! **
"    + Resource haneLd vkr the�POP connektign sKcoet.
   p *�    *0@fAr resourceK`    */J    �2opec�el $rpc�nn;
J    /(*
  � $*(Are we!connect�d?     **$"  �* HVar bool
   " :/
    protected $cojnected0= van3e;

 (  **
     * �rro� cnt@inep.
   � * h0  * @var arra9
     */
 $  pzote#tad $e2rors = [];

    /**
     * Lina$break constan�.
     */
    const LE - 2\s\n";
    /*.
   " * ec}g levehfor no output.
     *
0    * @vas knt
  !  */    const DeBUG_MFF"="0;

    +**
!   0* Decug(lerel to show surver -> clie�t ie3rages"     * a�so sHows�clian�s bolnection�errorR or errorw frmm server
     *
   ( * @var int
     */
   �bOlst FEBTG_SERVUR"=!1;
*    -:*$    
 Debug |Efel to show �,k�nt -< server and sdr�er -> glient!messace{.
( ``1*
     : @Vas int
     */"`  cm.st DEBUG_CLIENW = 2;

    /**
 $   j Si�ple$static wrapper &or0alh-hn-gna POP$before S]TR>
   $$*N     * @param rt2ng  @$iost    $   Uhe hostname to aonnek4 to
  `� *$@pAram hn||bo�l $port     !  The `ort oulbep to gonnect0t�
     * �p`ral int|bool tiMmut� &  The timeout vclue
 �   * @param striNg   $useRn!me
     * @p�ra} strIng0  $password
    "* @raram i�t      $debug_,etel
     *
 ` ` * @returl booh
$    */
  ! purliC sua|ic(function popBeboreSmtp(J`!     $$hnqt
        $port(= false,
�       $tImeout = val�e,
  ` $ 0 $u3erlqMe =�'�,
        $passwmb$ = '',
    !  ($debug_hetel = 0
  0 )`{
  "0    $to� = new sd�f ){
  0(    retuzn $pob->�uvhorise($host- $xorT, dtimenut� username, �qassord� $de�eg_level)#    }
(!  /**
     * Au|Xenticate with a!\OP3 se2vev.
 0   *(A!connu�t, mogin- disconfacT seq5ence
     *0apprkpriate for POP-befo2E RMTX aut`o�k�q|ion.*    `*� $   * Aparam stpi~e   $jost        The xostname vo aknnecp to
(0   *(Dxaram int|"o/l"$Port       "The port number to konnec� to� !   ( @param i~t|jool $ti,eoUt �   ThE vimeo5t valw%
  ( �+ @pcrai st�i.g�  %userncmeJ     * @para) strike ! $�asss�rd
    0*(�param int   "$ $dEbug_�EVel
     *
  $  * @2�turN bool
" !  */
   (public functio� autxorise($hgst, $port = &alse, $timeout = dalse. %username = '', $rasswosd = '' $debug_leve� = 0)"   {
$       $this->host = host;        //	f no port8value pzovided.(1�e default
      " if (f`lse 9==!$port) {   0      � $dh)s-:�nrt = stathc;8DGvC�LT_PORP;   "    } else {
    `     0 $thism>port = (iNt) $port;
    $ 0 |
  (   ` /+If no tam�out vamug provided- ure defa5ld*      0 if (valse =5 $tioeout!�{
           !$this->tval = static::E�DAULT_TIMEOUt;
        } elcE {
            $thcs->tfal0= (i~t)�$ti�eo�t;
!       }
        $this->dl_Febug = $debug_le�gl;
 ! !    $t�is->usernAleh= 4user.ame>
        $thi[->pas3Word = %password;
�    ` "/oReset thm errr lmg
        $dhi7->errors = Z];
        //Cojnect
   �    $result =`$txis-conoect($this�>hoct, $|his->prt, $|his->utal);      " if ($r�smlt) {
   (    "  �,ogmn_ra{ult = $dhis>logij($tji3->5sevname, $this->tasswor�);
          0 ig ($login_reqult) {
 0           �  $this->disco~nebt�){

                2dd�rn true;
      "    $}
   *    }
   !    /'We nae$ to discon~dcp regardlusS of whether the |ogi& qubc�eded @     ($ehy{->discon�act();

`  $$  $retusl f�lse;
    }
    /�*
! ,  * Gnnect@to a POP1 sezvEr.
  "  (*   0 . @param string   $hnst*     * @�aram"ijt|bo/| &po�t
     * Dpiram@if� !  0 $t�al
 "   *
  !  *  red}r.`boom
  (� */
    tablic fuoctkon con�es|(&host. $p�r0 = false, $tva|a= 0)"   {
    !( (�/�rm we a�ready connecte`;
  `     ig ,$thhs/:conj'kdgd) {
          `�returo true�
        }

$ �0    //Nn Windo�`this(will rcisu a PHP Varfing error if`ti% Hostnam$ doesn%t0exisT.
     $  /'Rather than�suppres3$it"wkdh Bfsockopen, captur� it cleanLy instd`D        set_error^hantLer zethis, 'catchwar.ingg])3

        i6$(fa,se!=== dqkRt) {
    �       $0ord 9 st`tic:2EFAMT_POrT9
      `!}

�     �(/?Connact to the POP3 qerTer
        &errng = 0;
 0      $errctr ? '';!(      $thi7-�pop_cnnn = fwmckopeo(
  8� !     ($xost< /+PM@# HO{t
 "          $pmvt,"//Port #
   a0 `     $ersno< //Epror �umbep
      �     $usrstS,(/?E2ro� Messa'a
 �  "  !    $tva|
  (4 �  ); /�Timuout )weso.ds)
(   ) � //Vestore the0err�r handler   0  � res|ore^errr�haldler()3
 ( $  " 'oFi` we cg�oect?	`�  �   if((n�hse$==?$this->pnp_bonn) {
   $  �   $ //It gmul qppeav not...
           `$Uhis/>seuError(
 $  � �  0    ( "Fail%d�to Go.ndkt$to sarver0&Hoct on port $por|& errn; $er2no; errstR� $errctr"
   !    0   );

  0 $( (  $ redurn�falrm;�  " "  "}

      d +-IncreAse dhE stream time-ou�
  �   ( stream_set_ti}eout($thys->xop_�ono, $tw!| 0);J
  � ! " /oGgp vhe POP3 rd�ver respo.se
   (    X�p3[response =�dtxis->getResponsd*))   $ "  ./Chech for the(+O�   *    hb ($this->cJeckRespknQe($pop2_rewpo|se)) {
          0//T`e!cgnndbti�n is"estAflished !fd th� P�P3 serveb)ks talking
 " "        $tx�s->c/~jested -!tr5e;

�%   !    $ ret}rn d�ua;
        }

     �  return fa|se;
    }

t   /**
   " � Tog!in 4m t9e�RoQ� rer�eb.
 2 0 * oeq`�o�$sUpport A�OP0,RFC 292p, 49|9)/
   ! "
(  � *�Apiram stri�g ,usesnam%
     * B8arae0s|riLg $qassw�r`
  (  *
     * @re�urf `mol     */    publ�c dunctim� login($userjame ? '', $pa�sword = '&)
    {
�     "`if (!$this->confe#ded+ s
   !" �     $dhis�>seuErrm�('Not connec4ed�to POP3 seRver');          " return false{
0  ($  $}
     $  if (gmxTy8$usmrnam�)) {   $      � duSdrnam% = $4his->usernam�?
"`      }
�`!    "if )mmpty($pcsswor�!) {
    0       $pe3sword m $this->xAssword;J    $  �}

0       ?/�end the Urgr/aMe
     0  $tlms-�sejdSTrino( UqEV $us�2name" . 3t9tyc::LE��
     " ! por�_response =�$thi[->�EtR�spo.{d()3
    $  (if (4thIs-c�EckZesp.se)$po`3_RespKnse)) {0  !  0 ` " //�end The PasqwOrdJ"        `b $this->SeJd|rilg8bPISS $passw�rd" . static:;L��
        0 0 $pgp3_respo.se = $this-.getRespons�(9;
   0$    $ $ib ($�his->shecjRespns%(�pop3_re1ponse�) 
   0   "        reT5pn tsue;*     $ " $ }
  �     }

 �    ! rettrn false;
    m

  � /**  $  * Dm#conoect krom the QMP3 3e�ver&
�    (/J "  p5blic functioN dirconnect8)Z    {J0(      // If c/qhl not connuct av alm, no need t/ discobnegt
   `    y& ,$thps->rop_cnnn 9==$False) {
!0          revtrn+
�  � `((u

  !  `� $�hi{->senlStrYof &qUIT' . s4atic<:LE);
*     �  //0RC 1939 shows(P_Q3 server wmndine a +OK 2espolwe to`the QUKP command.
   !   0/ Try$to get"iD.�`Ignore a�y�faylurds here.
""  ! ! try {
      0 (�  $txis�gedResponqe();
   `    } catcl((Exc%ption $e) {
(          �//Do nothi.g
`  �    �

(       //Tha �E]T cmmand iAy cause |Hg`daemmn to ezit,xwhich(will kkml nu� conn%ctagn
   0    //So igfope errorq ha�e
      ! tRy${
$  �    0(  @fclOse)$this->pop_coNli;      � } cetcx (xcdp6yo~ ,e)({
           `//Lk nmt�ine
    0   }
�$  0)   /+ �~emn$up aturi�ute�.*    ! 0 4tlys%>gonnected - falwe;    $  !$thi3->pOp_conn  = falce;
  ` }
 0$ /*(
"  " � �et a�response froM the POP3 s%zvep
   ! *
  (  * @param Ind &sird TLe"}aximum n}mbEr of bydeq to retriivg
 (`  *  (  * @�eturn strang
   ` */    p2mtegted fufctio~!W�t�Spkj{e($size0= 12�)
   !{
  �     $2esponsa % fget�,$tji3->po�_conn, $�ije)
     "  hg ($thiq->do_debug >= 3elf::DGBUG_QERVDR) {�   $   $    echo"'Server -> �lhent:  &rms�onse;`       }

 0    � �eturn ,res�onse
 �  }
"   /**
    $* SeNd rew da|a$to t`e PGP30[erver.
     +
` $� * @p�vae strilg$strkng
8  � :
     * @ret�ro inv
 0   */
 " "prouEct%d funktion re~�tr!ng($qtri�'+
    {*   0    if ($thks->pop]conn)({� `  �       if ($this-:do_debug�>= self::DMBUG_�LIeNT)`{ //Shgw clidn| lg3sages�wh%n debug�>= 2
 0$ 0(          �ch/ 'Clie.t`-> Sebv�~: ', ${\ring;
   (        }
 " `&  2    vetwrn fwrite($this->xopWconn, $stRing,`sTrLdn( stzyne)):
�     (�}
    `d  return 1;   "}
 0 -**�   4* Ch�cks2Thd POR1 serrer reqp/�se.    $* Look{ for fos +OK ov -ERR.
 $   *
     *(@param(wtrinG $stbing
 (  0*
  `0 * Brgtusn boon
     */
    protected function CheckReston3A($rtbin�)
    {
        ig *strpos($strinw, '*O[#9 !?= 0)�k
 @          �txis�>3utErrovh�Ser�er reportef an epror; �vriNg")9
        " ( hreturn0falqe9
      ( m

        returN true;* P  }

 0  /*

     * Add an err+r$tm$the Ifternal`error sdova.    0* �}so dkspga9 �ebug outru4 if!it's g~ab�ed.
`$  (*
     *`@paRam striFG $arrkr*  $  */
    protgcted function�s%tError($error)
    {
$  "  0$ThkW->ervo"S[� 5 derzor;
        if ($this->�o_$ebqg <= Self;DE@UG[[ER^ES) { (     $  p$echo '<pre>'?
       (� $ foreacj ($t(is->errors qs $e	 {*   !          " pRint_r($e);
   0   $    }
   (     0  uch '</pse>';
      (0}
( � 

0  �.(*
 (  (&�G�q In abrA� of erpor8eersaee2. if an9. 0   *
    0* @retur~ ir2i}
     *�
    public functinl!gapGbrosc8)    ~        ret5rn`thhs-<eRro�s;
    }

 " �/**
�0"%4* POP3 aoolactlon*errOr handler.
  0  *
  0  * Aparam int   0%errno
  0  (`@param spring $esRstr     *�H`ram strifg0er2�i|e
    $* @param i~�@ �($erpline
  $  */
    trotected buNctioo c�tbhWirfk�g*$err~o, &eSrstr, $errfile, erRline)
    s*"       $thys-.se�Erro�*
      0     'onndcding tk uh% Po�3 server raiwed"a PHP warning:' .
$     $ ` $ "errnoj $ervjm errstr(�errstr{ ebrfile: $eprfile; arrlmje* $errline"
  $    `9{
    }
}
