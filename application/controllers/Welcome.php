<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->database();
		$this->load->view('header');
		$this->load->view('nav');
		include_once 'dom.php';
		$query = $this->db->query("SELECT * FROM google_scholar ORDER BY scholar_pib ASC");
		$data = array();
		$data['list'] = "";
		

		$data['list'] .= "
		  <div class='toolbar'>
      <input type='text' name='' placeholder='Пошук'class='findbar'>
    </div>
    
    <script>
$(document).ready(function()
{
	  $('.table').tablesorter();

    $('.findbar').keyup(function()
    {
    _this = this;  
    
    $.each($('.table tbody tr'), function()
     {
        if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1) 
        {
            $(this).hide();
        } 
        else 
        {
            $(this).show(); 
            }             
        });
    });
});
</script>
		<div class='x_panel'>
                
                  <div class='x_content'>
                  <table id='datatable-fixed-headerclass' class='table table-striped table-bordered'>
			<thead>
				<tr>
					<th><i class='uk-icon-refresh'></i></th>
					<th>ПІБ</th>
					<th>Full Name</th>
					<th>ORCID</th>
					<th>Scopus</th>
					<th>h</th>
					<th>Scholar</th>
					<th>h2</th>		
					<th>Researcher</th>
					<th>h3</th>						
				</tr>
			</thead>
			<tbody>";
			
			foreach ($query->result() as $row) {
				$stats = json_decode($row->scholar_stats, true);
				$data['list'] .= "<tr>
					<td><a href='".site_url()."update/index/".$row->scholar_id."/'><i class='uk-icon-refresh'></i></a></td>
					<td>".$row->scholar_pib."</td>
					<td>".$row->scopus_pib."</td>
					<td>".$row->scopus_orcid."</td>
					<td>".($row->scopus_idn == "" ? "" : "<a href='//www.scopus.com/authid/detail.uri?authorId=".$row->scopus_idn."' target='_blank'>".$row->scopus_idn."</a><!--<br><input value='https://www.scopus.com/authid/detail.uri?authorId=".$row->scopus_idn."'>-->")."</td>
					<td>".$row->scopus_stats."</td>
					<td>".($row->scholar_idn == "" ? "" : "<a href='//scholar.google.com.ua/citations?user=".$row->scholar_idn."' target='_blank'>".$row->scholar_idn."</a><!--<br><input value='https://scholar.google.com.ua/citations?user=".$row->scholar_idn."'>-->")."</td>
					<td>".(!empty($stats[2]) ? $stats[2] : "-")."</td>
					<td>".($row->researcher_id == "" ? "" : "<a href='//www.researcherid.com/rid/".$row->researcher_id."' target='_blank'>".$row->researcher_id."</a><!--<br><input value='//www.researcherid.com/rid/".$row->researcher_id."'>-->")."</td>
					<td>".$row->researcher_stats."</td>					
				</tr>";
			}
			
		
		$data['list'] .= "</tbody>
		</table>
 <script>

        $(document).ready(function() 
        {
        	$('table tr').click(function() 
        		{
        			var rowIndex=$('table tr').index(this);
        			if(rowIndex!=0)
        			{
        				var txt = $(this).find('td:eq(1)').html();
						var url = 'http://wiki.lp.edu.ua/wiki/index.php?search='+txt+'&title=Спеціальна%3AПошук&go=Перейти';   
						$.ajax({
    						type: 'get',
    						url: '/application/controllers/wiki_api.php',
    						data: {url: url},
    						contentType: 'text/plain',
    						success: function(data)
    							{
        							window.open('http://wiki.lp.edu.ua'+data);
    							}
							   });
					}
  
  				});
		});
 </script>
		</div></div>";
		
		$this->load->view('footer', $data);
	}
}
