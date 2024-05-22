<div style="border:1px solid #cccccc;width:800px;margin:0 auto;padding:15px;box-sizing: border-box;">
	<div style="background-color:#001e47;float: left;width: 100%;font-family:'Droid Serif',serif;">
		<div style="float:left;width:100%;font-size:18px;color:#fff;padding: 10px;">
			Dear Admin
		</div>
	</div>
	<div style="clear:both"></div>
	<p><strong>Contact Form Query</strong><br></p>
	<p></p>
	<div style="margin:20px 0">
		<table style="float:left;width: 100%;margin-bottom:20px;">
			<tbody>
				<tr style="float:left;padding:0px 30px;clear:both">
					<td style="font-weight:bold;padding-right:8px;">Name: </td>
					<td> {{ $contact_data->name }}</td>
				</tr>
				<tr style="float:left;padding:0px 30px;clear:both">
					<td style="font-weight:bold;padding-right:8px;">Email: </td>
					<td> {{ $contact_data->email }}</td>
				</tr>
				<tr style="float:left;padding:0px 30px;clear:both">
					<td style="font-weight:bold;padding-right:8px;">Phone: </td>
					<td> {{ $contact_data->phone }}</td>
				</tr>
				<tr style="float:left;padding:0px 30px;clear:both">
					<td> {{ $contact_data->message }}</td>
				</tr>
			</tbody>
		</table>
		<div style="clear:both"></div>
	</div>
	<div>
		<b>Thank you!</b><br>
		<h3>JBChauffeurs.com</h3>
	</div>
	<div style="background-color:#001e47;padding:8px;color:#fff;text-align:center">
        © {{ date('Y')}} <a href="https://www.jbchauffeurs.com/" style="color:#fff"> Jbchauffeurs.com </a>. All Right Reserved.
	</div>
</div>