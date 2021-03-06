<?php
$_CAMILA['page']->camila_worktable = true;

$wt_id = substr($_SERVER['PHP_SELF'], 12, -4);

if (intval($wt_id) > 0)
    $_CAMILA['page']->camila_worktable_id = $wt_id;

function worktable_get_safe_temp_filename($name) {
    global $_CAMILA;
    return CAMILA_TMP_DIR . '/lastval_' . $_CAMILA['lang'] . '_' . preg_replace('/[^a-z]/', '', strtolower($name));
}

function worktable_get_last_value_from_file($name) {
    return file_get_contents(worktable_get_safe_temp_filename($name));
}


function worktable_get_next_autoincrement_value($table, $column) {

    global $_CAMILA;

    $result = $_CAMILA['db']->Execute('select max('.$column.') as id from ' . $table);
    if ($result === false)
        camila_error_page(camila_get_translation('camila.sqlerror') . ' ' . $_CAMILA['db']->ErrorMsg());

    return intval($result->fields['id']) + 1;

}


function worktable_parse_default_expression($expression, $form) {
    return camila_parse_default_expression($expression, $form->fields['id']->defaultvalue);
}


if (camila_form_in_update_mode(segreteriacampo_worktable18)) {

    

    $form = new dbform('segreteriacampo_worktable18', 'id');

    if ($_CAMILA['adm_user_group'] != CAMILA_ADM_USER_GROUP)
    {
        $form->caninsert = true;
        $form->candelete = true;
        $form->canupdate = true;
    }
    else
    if ($_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP)
    {
        $form->caninsert = true;
        $form->candelete = true;
        $form->canupdate = true;
    }

    $form->drawrules = true;
    $form->drawheadersubmitbutton = true;

    new form_textbox($form, 'id', camila_get_translation('camila.worktable.field.id'));
    if (is_object($form->fields['id'])) {
        if ($_REQUEST['camila_update'] == 'new' && !isset($_REQUEST['camila_phpform_sent'])) {
            $_CAMILA['db_genid'] = $_CAMILA['db']->GenID(CAMILA_APPLICATION_PREFIX.'worktableseq', 100000);
            $form->fields['id']->defaultvalue = $_CAMILA['db_genid'];
        }
        $form->fields['id']->updatable = false;
        $form->fields['id']->forcedraw = true;
    }

    
    new form_textbox($form, 'organizzazione', 'ORGANIZZAZIONE', true, 30, 255, 'uppercase');

    
    new form_textbox($form, 'cognome', 'COGNOME', true, 30, 255, 'uppercase');

    
    new form_textbox($form, 'nome', 'NOME', true, 30, 255, 'uppercase');

    
    new form_textbox($form, 'codicevolontario', 'CODICE VOLONTARIO', false, 30, 255, '');

if (is_object($form->fields['codicevolontario'])) $form->fields['codicevolontario']->autofocus = true;
    
    new form_textbox($form, 'codicefiscale', 'CODICE FISCALE', false, 30, 255, '');

    
    new form_static_listbox($form, 'mansione', 'MANSIONE', 'OPERATORE LOGISTICO (GENERICO),OPERATORE LOGISTICO (INSACCHETTAMENTO),OPERATORE LOGISTICO (MOTOSEGA),OPERATORE LOGISTICO (MOTOPOMPE),OPERATORE LOGISTICO (SUB),OPERATORE CINOFILO,OPERATORE SEGRETERIA,OPERATORE SALA OPERATIVA,OPERATORE RADIO,OPERATORE NAUTICO,ELETTRICISTA,MURATORE,IDRAULICO,OPERATORE SANITARIO,OPERATORE CUCINA,OPERATORE ANTINCENDIO,OPERATORE A CAVALLO,OPERATORE SUBACQUEO', false, '');

    
    new form_textbox($form, 'servizio', 'SERVIZIO', false, 30, 255, '');
if (is_object($form->fields['servizio'])) $form->fields['servizio']->defaultvalue = worktable_parse_default_expression('IN ATTESA DI SERVIZIO', $form);

    
    new form_static_listbox($form, 'responsabile', 'RESPONSABILE', 'NO,SI', false, '');
if (is_object($form->fields['responsabile'])) $form->fields['responsabile']->help = 'Responsabile operativo (es. caposquadra) o responsabile di missione o funzione.';
if (is_object($form->fields['responsabile'])) $form->fields['responsabile']->defaultvalue = worktable_parse_default_expression('N', $form);

    
    new form_textbox($form, 'cellulare', 'CELLULARE', false, 30, 255, '');
if (is_object($form->fields['cellulare'])) $form->fields['cellulare']->help = 'Preferibile indicare un recapito telefonico per ogni responsabile.';

    
    new form_static_listbox($form, 'autista', 'AUTISTA', 'n.d.,NO,SI', false, '');
if (is_object($form->fields['autista'])) $form->fields['autista']->help = 'Indicare se autista di uno dei mezzi in servizio.';

    
    new form_static_listbox($form, 'pranzo', 'PRANZO', 'n.d.,NO,SI', false, '');

    
    new form_static_listbox($form, 'cena', 'CENA', 'n.d.,NO,SI', false, '');

    
    new form_static_listbox($form, 'pernottamento', 'PERNOTTAMENTO', 'n.d.,NO,SI', false, '');

    
    new form_textbox($form, 'problemialimentari', 'PROBLEMI ALIMENTARI', false, 30, 255, '');

    
    new form_static_listbox($form, 'beneficidilegge', 'BENEFICI DI LEGGE', 'n.d.,NO,SI', false, '');
if (is_object($form->fields['beneficidilegge'])) $form->fields['beneficidilegge']->help = 'Indicare se intende usufruire dei benefici di legge (DPR 194/2001).';
if (is_object($form->fields['beneficidilegge'])) $form->fields['beneficidilegge']->defaultvalue = worktable_parse_default_expression('N', $form);

    
    new form_integer($form, 'numggbenlegge', 'NUM. GG. BEN. LEGGE', false, 5, 255, '');

    
    new form_textbox($form, 'provincia', 'PROVINCIA', true, 30, 255, '');

    
    new form_textbox($form, 'codiceorganizzazione', 'CODICE ORGANIZZAZIONE', false, 30, 255, '');

    
    new form_textbox($form, 'turno', 'TURNO', false, 30, 255, '');
if (is_object($form->fields['turno'])) $form->fields['turno']->defaultvalue = worktable_get_last_value_from_file('TURNO');
if (is_object($form->fields['turno'])) $form->fields['turno']->write_value_to_file = worktable_get_safe_temp_filename('TURNO');

    
    new form_textbox($form, 'codicebadge', 'CODICE BADGE', false, 30, 255, '');
if (is_object($form->fields['codicebadge'])) $form->fields['codicebadge']->defaultvalue = worktable_parse_default_expression('${prefissocodiceabarre}${codice riga}', $form);

    
    new form_date($form, 'datainizioattestato', 'DATA INIZIO ATTESTATO', true, '');
if (is_object($form->fields['datainizioattestato'])) $form->fields['datainizioattestato']->defaultvalue = date('Y-m-d');

    
    new form_date($form, 'datafineattestato', 'DATA FINE ATTESTATO', false, '');

    
    new form_datetime($form, 'dataoraregistrazione', 'DATA/ORA REGISTRAZIONE', false, '');
if (is_object($form->fields['dataoraregistrazione'])) $form->fields['dataoraregistrazione']->hslots = 60;
if (is_object($form->fields['dataoraregistrazione'])) $form->fields['dataoraregistrazione']->defaultvalue = date('Y-m-d H:i:s');

    
    new form_datetime($form, 'dataorauscitadefinitiva', 'DATA/ORA USCITA DEFINITIVA', false, '');
if (is_object($form->fields['dataorauscitadefinitiva'])) $form->fields['dataorauscitadefinitiva']->hslots = 60;

    
    new form_textbox($form, 'note', 'NOTE', false, 30, 255, '');

    

    if (CAMILA_WORKTABLE_SPECIAL_ICON_ENABLED || $_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP)
        new form_static_listbox($form, 'cf_bool_is_selected', camila_get_translation('camila.worktable.field.selected'), camila_get_translation('camila.worktable.options.noyes'));

    if (CAMILA_WORKTABLE_SELECTED_ICON_ENABLED || $_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP)
        new form_static_listbox($form, 'cf_bool_is_special', camila_get_translation('camila.worktable.field.special'), camila_get_translation('camila.worktable.options.noyes'));

    if ($_REQUEST['camila_update'] != 'new') {

    new form_datetime($form, 'created', camila_get_translation('camila.worktable.field.created'));
    if (is_object($form->fields['created'])) $form->fields['created']->updatable = false;

    new form_textbox($form, 'created_by', camila_get_translation('camila.worktable.field.created_by'));
    if (is_object($form->fields['created_by'])) $form->fields['created_by']->updatable = false;

    new form_textbox($form, 'created_by_surname', camila_get_translation('camila.worktable.field.created_by_surname'));
    if (is_object($form->fields['created_by_surname'])) $form->fields['created_by_surname']->updatable = false;

    new form_textbox($form, 'created_by_name', camila_get_translation('camila.worktable.field.created_by_name'));
    if (is_object($form->fields['created_by_name'])) $form->fields['created_by_name']->updatable = false;

    new form_static_listbox($form, 'created_src', camila_get_translation('camila.worktable.field.created_src'), camila_get_translation('camila.worktable.options.recordmodsrc'));
    if (is_object($form->fields['created_src'])) $form->fields['created_src']->updatable = false;

    new form_datetime($form, 'last_upd', camila_get_translation('camila.worktable.field.last_upd'));
    if (is_object($form->fields['last_upd'])) $form->fields['last_upd']->updatable = false;

    new form_textbox($form, 'last_upd_by', camila_get_translation('camila.worktable.field.last_upd_by'));
    if (is_object($form->fields['last_upd_by'])) $form->fields['last_upd_by']->updatable = false;

    new form_textbox($form, 'last_upd_by_surname', camila_get_translation('camila.worktable.field.last_upd_by_surname'));
    if (is_object($form->fields['last_upd_by_surname'])) $form->fields['last_upd_by_surname']->updatable = false;

    new form_textbox($form, 'last_upd_by_name', camila_get_translation('camila.worktable.field.last_upd_by_name'));
    if (is_object($form->fields['last_upd_by_name'])) $form->fields['last_upd_by_name']->updatable = false;

    new form_textbox($form, 'last_upd_by_name', camila_get_translation('camila.worktable.field.last_upd_by_name'));
    if (is_object($form->fields['last_upd_by_name'])) $form->fields['last_upd_by_name']->updatable = false;

    new form_static_listbox($form, 'last_upd_src', camila_get_translation('camila.worktable.field.last_upd_src'), camila_get_translation('camila.worktable.options.recordmodsrc'));
    if (is_object($form->fields['last_upd_src'])) $form->fields['last_upd_src']->updatable = false;

    new form_textbox($form, 'mod_num', camila_get_translation('camila.worktable.field.mod_num'));
    if (is_object($form->fields['mod_num'])) $form->fields['mod_num']->updatable = false;


}

    if (is_object($form->fields['organizzazione']))
{
$form->fields['organizzazione']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['organizzazione']->autosuggest_field = 'organizzazione';
$form->fields['organizzazione']->autosuggest_idfield = 'id';
$form->fields['organizzazione']->autosuggest_infofields = 'cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note';
$form->fields['organizzazione']->autosuggest_pickfields = 'cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note';
$form->fields['organizzazione']->autosuggest_destfields = 'cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note';
}
if (is_object($form->fields['cognome']))
{
$form->fields['cognome']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['cognome']->autosuggest_field = 'cognome';
$form->fields['cognome']->autosuggest_idfield = 'id';
$form->fields['cognome']->autosuggest_infofields = 'nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione';
$form->fields['cognome']->autosuggest_pickfields = 'nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione';
$form->fields['cognome']->autosuggest_destfields = 'nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione';
}
if (is_object($form->fields['nome']))
{
$form->fields['nome']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['nome']->autosuggest_field = 'nome';
$form->fields['nome']->autosuggest_idfield = 'id';
$form->fields['nome']->autosuggest_infofields = 'codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome';
$form->fields['nome']->autosuggest_pickfields = 'codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome';
$form->fields['nome']->autosuggest_destfields = 'codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome';
}
if (is_object($form->fields['codicevolontario']))
{
$form->fields['codicevolontario']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['codicevolontario']->autosuggest_field = 'codicevolontario';
$form->fields['codicevolontario']->autosuggest_idfield = 'id';
$form->fields['codicevolontario']->autosuggest_infofields = 'codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome';
$form->fields['codicevolontario']->autosuggest_pickfields = 'codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome';
$form->fields['codicevolontario']->autosuggest_destfields = 'codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome';
}
if (is_object($form->fields['codicefiscale']))
{
$form->fields['codicefiscale']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['codicefiscale']->autosuggest_field = 'codicefiscale';
$form->fields['codicefiscale']->autosuggest_idfield = 'id';
$form->fields['codicefiscale']->autosuggest_infofields = 'mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario';
$form->fields['codicefiscale']->autosuggest_pickfields = 'mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario';
$form->fields['codicefiscale']->autosuggest_destfields = 'mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario';
}
if (is_object($form->fields['mansione']))
{
$form->fields['mansione']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['mansione']->autosuggest_field = 'mansione';
$form->fields['mansione']->autosuggest_idfield = 'id';
$form->fields['mansione']->autosuggest_infofields = 'responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale';
$form->fields['mansione']->autosuggest_pickfields = 'responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale';
$form->fields['mansione']->autosuggest_destfields = 'responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale';
}
if (is_object($form->fields['responsabile']))
{
$form->fields['responsabile']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['responsabile']->autosuggest_field = 'responsabile';
$form->fields['responsabile']->autosuggest_idfield = 'id';
$form->fields['responsabile']->autosuggest_infofields = 'cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione';
$form->fields['responsabile']->autosuggest_pickfields = 'cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione';
$form->fields['responsabile']->autosuggest_destfields = 'cellulare,problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione';
}
if (is_object($form->fields['cellulare']))
{
$form->fields['cellulare']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['cellulare']->autosuggest_field = 'cellulare';
$form->fields['cellulare']->autosuggest_idfield = 'id';
$form->fields['cellulare']->autosuggest_infofields = 'problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile';
$form->fields['cellulare']->autosuggest_pickfields = 'problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile';
$form->fields['cellulare']->autosuggest_destfields = 'problemialimentari,provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile';
}
if (is_object($form->fields['problemialimentari']))
{
$form->fields['problemialimentari']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['problemialimentari']->autosuggest_field = 'problemialimentari';
$form->fields['problemialimentari']->autosuggest_idfield = 'id';
$form->fields['problemialimentari']->autosuggest_infofields = 'provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare';
$form->fields['problemialimentari']->autosuggest_pickfields = 'provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare';
$form->fields['problemialimentari']->autosuggest_destfields = 'provincia,codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare';
}
if (is_object($form->fields['provincia']))
{
$form->fields['provincia']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['provincia']->autosuggest_field = 'provincia';
$form->fields['provincia']->autosuggest_idfield = 'id';
$form->fields['provincia']->autosuggest_infofields = 'codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari';
$form->fields['provincia']->autosuggest_pickfields = 'codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari';
$form->fields['provincia']->autosuggest_destfields = 'codiceorganizzazione,note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari';
}
if (is_object($form->fields['codiceorganizzazione']))
{
$form->fields['codiceorganizzazione']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['codiceorganizzazione']->autosuggest_field = 'codiceorganizzazione';
$form->fields['codiceorganizzazione']->autosuggest_idfield = 'id';
$form->fields['codiceorganizzazione']->autosuggest_infofields = 'note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia';
$form->fields['codiceorganizzazione']->autosuggest_pickfields = 'note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia';
$form->fields['codiceorganizzazione']->autosuggest_destfields = 'note,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia';
}
if (is_object($form->fields['note']))
{
$form->fields['note']->autosuggest_table = 'segreteriacampo_worktable22';
$form->fields['note']->autosuggest_field = 'note';
$form->fields['note']->autosuggest_idfield = 'id';
$form->fields['note']->autosuggest_infofields = 'organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione';
$form->fields['note']->autosuggest_pickfields = 'organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione';
$form->fields['note']->autosuggest_destfields = 'organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,responsabile,cellulare,problemialimentari,provincia,codiceorganizzazione';
}


    $form->process();
    
    $form->draw();

} else {
      $report_fields = 'id,cf_bool_is_special,cf_bool_is_selected,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,servizio,responsabile,cellulare,autista,pranzo,cena,pernottamento,problemialimentari,beneficidilegge,numggbenlegge,provincia,codiceorganizzazione,turno,codicebadge,datainizioattestato,datafineattestato,dataoraregistrazione,dataorauscitadefinitiva,note,created,created_by,created_by_surname,created_by_name,last_upd,last_upd_by,last_upd_by_surname,last_upd_by_name,mod_num';
	  //$admin_report_fields = '';
      $default_fields = 'cf_bool_is_special,cf_bool_is_selected,organizzazione,cognome,nome,codicevolontario,codicefiscale,mansione,servizio,responsabile,cellulare,autista,pranzo,cena,pernottamento,problemialimentari,beneficidilegge,numggbenlegge,provincia,codiceorganizzazione,turno,codicebadge,datainizioattestato,datafineattestato,dataoraregistrazione,dataorauscitadefinitiva,note';

      if (isset($_REQUEST['camila_rest'])) {
          $report_fields = str_replace('cf_bool_is_special,', '', $report_fields);
          $report_fields = str_replace('cf_bool_is_selected,', '', $report_fields);
          $default_fields = $report_fields;
      }
	  
	  //if ($_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP)
		//  $default_fields = $admin_report_fields;

      if ($_CAMILA['page']->camila_exporting())
          $mapping = 'created=Data creazione#last_upd=Ultimo aggiornamento#last_upd_by=Utente ult. agg.#last_upd_src=Sorgente Ult. agg.#last_upd_by_name=Nome Utente ult. agg.#last_upd_by_surname=Cognome Utente ult. agg.#mod_num=Num. mod.#id=Cod. riga#created_by=Utente creaz.#created_src=Sorgente creaz.#created_by_surname=Cognome Utente creaz.#created_by_name=Nome Utente creaz.#cf_bool_is_special=contrassegnati come speciali#cf_bool_is_selected=selezionati#organizzazione=ORGANIZZAZIONE#cognome=COGNOME#nome=NOME#codicevolontario=CODICE VOLONTARIO#codicefiscale=CODICE FISCALE#mansione=MANSIONE#servizio=SERVIZIO#responsabile=RESPONSABILE#cellulare=CELLULARE#autista=AUTISTA#pranzo=PRANZO#cena=CENA#pernottamento=PERNOTTAMENTO#problemialimentari=PROBLEMI ALIMENTARI#beneficidilegge=BENEFICI DI LEGGE#numggbenlegge=NUM. GG. BEN. LEGGE#provincia=PROVINCIA#codiceorganizzazione=CODICE ORGANIZZAZIONE#turno=TURNO#codicebadge=CODICE BADGE#datainizioattestato=DATA INIZIO ATTESTATO#datafineattestato=DATA FINE ATTESTATO#dataoraregistrazione=DATA/ORA REGISTRAZIONE#dataorauscitadefinitiva=DATA/ORA USCITA DEFINITIVA#note=NOTE';
      else
          $mapping = 'created=Data creazione#last_upd=Ultimo aggiornamento#last_upd_by=Utente ult. agg.#last_upd_src=Sorgente Ult. agg.#last_upd_by_name=Nome Utente ult. agg.#last_upd_by_surname=Cognome Utente ult. agg.#mod_num=Num. mod.#id=Cod. riga#created_by=Utente creaz.#created_src=Sorgente creaz.#created_by_surname=Cognome Utente creaz.#created_by_name=Nome Utente creaz.#cf_bool_is_special=contrassegnati come speciali#cf_bool_is_selected=selezionati#organizzazione=ORGANIZZAZIONE#cognome=COGNOME#nome=NOME#codicevolontario=COD. VOLONTARIO#codicefiscale=CODICE FISCALE#mansione=MANSIONE#servizio=SERVIZIO#responsabile=RESP.#cellulare=CELLULARE#autista=AUTISTA#pranzo=PRANZO#cena=CENA#pernottamento=PERN.#problemialimentari=PROB. ALIM.#beneficidilegge=BENEFICI DI LEGGE#numggbenlegge=NUM. GG. BEN. LEGGE#provincia=PROVINCIA#codiceorganizzazione=COD. ORGANIZZAZIONE#turno=TURNO#codicebadge=CODICE BADGE#datainizioattestato=DATA INIZIO ATTEST.#datafineattestato=DATA FINE ATTEST.#dataoraregistrazione=DATA/ORA REG.#dataorauscitadefinitiva=DATA/ORA USCITA#note=NOTE';

      $filter = '';

      if ($_CAMILA['user_visibility_type']=='personal')
          $filter= ' where created_by='.$_CAMILA['db']->qstr($_CAMILA['user']);
	  
	  if ($_CAMILA['user_visibility_type']=='group')
          $filter= ' where grp='.$_CAMILA['db']->qstr($_CAMILA['user_group']);

	  //if ($_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP)
	//	  $stmt = 'select ' . $admin_report_fields . ' from segreteriacampo_worktable18';
	  //else
		  $stmt = 'select ' . $report_fields . ' from segreteriacampo_worktable18';
      
      $report = new report($stmt.$filter, '', 'organizzazione', 'asc', $mapping, null, 'id', $default_fields, '', (isset($_REQUEST['camila_rest'])) ? false : true, (isset($_REQUEST['camila_rest'])) ? false : true);

      if (true && !isset($_REQUEST['camila_rest'])) {
          $report->additional_links = Array(camila_get_translation('camila.report.insertnew') => basename($_SERVER['PHP_SELF']) . '?camila_update=new');

          $myImage1 = new CHAW_image(CAMILA_IMG_DIR . 'wbmp/add.wbmp', CAMILA_IMG_DIR . 'png/add.png', '-');
          //$report->additional_links_images = Array(camila_get_translation('camila.report.insertnew') => $myImage1);
		  $report->additional_links_css_classes = Array(camila_get_translation('camila.report.insertnew') => 'btn '.CAMILA_UI_DEFAULT_BTN_SIZE.' btn-default btn-primary');

          if (($_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP) || CAMILA_WORKTABLE_IMPORT_ENABLED)          
          $report->additional_links[camila_get_translation('camila.worktable.import')] = 'cf_worktable_wizard_step4.php?camila_custom=' . $wt_id . '&camila_returl=' . urlencode($_SERVER['PHP_SELF']);
      }

      if ($_CAMILA['adm_user_group'] == CAMILA_ADM_USER_GROUP) {
          $report->additional_links[camila_get_translation('camila.worktable.rebuild')] = 'cf_worktable_admin.php?camila_custom=' . $wt_id . '&camila_worktable_op=rebuild' . '&camila_returl=' . urlencode($_SERVER['PHP_SELF']);
          $report->additional_links[camila_get_translation('camila.worktable.reconfig')] = 'cf_worktable_wizard_step2.php?camila_custom=' . $wt_id . '&camila_returl=' . urlencode($_SERVER['PHP_SELF']);
      }

      if (CAMILA_WORKTABLE_CONFIRM_VIA_MAIL_ENABLED) {
          $report->additional_links[camila_get_translation('camila.worktable.confirm')] = basename($_SERVER['PHP_SELF']) . '?camila_visible_cols_only=y&camila_worktable_export=dataonly&camila_pagnum=-1&camila_export_filename=WORKTABLE&camila_export_action=sendmail&hidden=camila_xls&camila_export_format=camila_xls&camila_xls=Esporta';

          $myImage1 = new CHAW_image(CAMILA_IMG_DIR . 'wbmp/accept.wbmp', CAMILA_IMG_DIR . 'png/accept.png', '-');
          $report->additional_links_images[camila_get_translation('camila.worktable.confirm')]=$myImage1;

      }

      $report->formulas=Array();
      $report->queries=Array();

      $jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('organizzazione','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA ORGANIZZAZIONE...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('cognome','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA COGNOME...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('nome','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA NOME...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('codicevolontario','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA CODICE VOLONTARIO...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('codicefiscale','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA CODICE FISCALE...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'mansione';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA MANSIONE';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE LOGISTICO (GENERICO)')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE LOGISTICO (GENERICO)';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE LOGISTICO (INSACCHETTAMENTO)')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE LOGISTICO (INSACCHETTAMENTO)';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE LOGISTICO (MOTOSEGA)')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE LOGISTICO (MOTOSEGA)';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE LOGISTICO (MOTOPOMPE)')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE LOGISTICO (MOTOPOMPE)';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE LOGISTICO (SUB)')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE LOGISTICO (SUB)';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE CINOFILO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE CINOFILO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE SEGRETERIA')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE SEGRETERIA';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE SALA OPERATIVA')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE SALA OPERATIVA';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE RADIO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE RADIO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE NAUTICO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE NAUTICO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','ELETTRICISTA')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'ELETTRICISTA';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','MURATORE')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MURATORE';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','IDRAULICO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'IDRAULICO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE SANITARIO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE SANITARIO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE CUCINA')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE CUCINA';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE ANTINCENDIO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE ANTINCENDIO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE A CAVALLO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE A CAVALLO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('mansione','OPERATORE SUBACQUEO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'OPERATORE SUBACQUEO';
$jarr['parent'] = 'mansione';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('servizio','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA SERVIZIO...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'responsabile';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA RESPONSABILE';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('responsabile','NO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'NO';
$jarr['parent'] = 'responsabile';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('responsabile','SI')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'SI';
$jarr['parent'] = 'responsabile';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('cellulare','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA CELLULARE...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'autista';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA AUTISTA';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('autista','n.d.')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'n.d.';
$jarr['parent'] = 'autista';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('autista','NO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'NO';
$jarr['parent'] = 'autista';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('autista','SI')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'SI';
$jarr['parent'] = 'autista';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'pranzo';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA PRANZO';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('pranzo','n.d.')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'n.d.';
$jarr['parent'] = 'pranzo';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('pranzo','NO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'NO';
$jarr['parent'] = 'pranzo';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('pranzo','SI')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'SI';
$jarr['parent'] = 'pranzo';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'cena';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA CENA';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('cena','n.d.')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'n.d.';
$jarr['parent'] = 'cena';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('cena','NO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'NO';
$jarr['parent'] = 'cena';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('cena','SI')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'SI';
$jarr['parent'] = 'cena';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'pernottamento';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA PERNOTTAMENTO';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('pernottamento','n.d.')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'n.d.';
$jarr['parent'] = 'pernottamento';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('pernottamento','NO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'NO';
$jarr['parent'] = 'pernottamento';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('pernottamento','SI')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'SI';
$jarr['parent'] = 'pernottamento';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('problemialimentari','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA PROBLEMI ALIMENTARI...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = 'beneficidilegge';
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA BENEFICI DI LEGGE';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('beneficidilegge','n.d.')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'n.d.';
$jarr['parent'] = 'beneficidilegge';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('beneficidilegge','NO')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'NO';
$jarr['parent'] = 'beneficidilegge';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('beneficidilegge','SI')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'SI';
$jarr['parent'] = 'beneficidilegge';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('provincia','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA PROVINCIA...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('codiceorganizzazione','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA CODICE ORGANIZZAZIONE...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('turno','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA TURNO...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('codicebadge','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA CODICE BADGE...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('datainizioattestato','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA DATA INIZIO ATTESTATO...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('datafineattestato','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA DATA FINE ATTESTATO...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;
$jarr=Array();
$jarr['url'] = "javascript:camila_inline_update_selected('note','')";
$jarr['visible'] = 'yes';
$jarr['short_title'] = 'MODIFICA NOTE...';
$jarr['parent'] = 'index.php';
$report->menuitems[]=$jarr;


      $report->process();
      $report->draw();

}
?>