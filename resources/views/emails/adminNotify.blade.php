<div style="border:1px solid #cccccc;width:800px;margin:0 auto;padding:15px;box-sizing: border-box;">
	<div style="background-color:#001e47;float: left;width: 100%;font-family:'Droid Serif',serif;">
		<div style="float:left;width:100%;font-size:18px;color:#fff;padding: 10px;">
			Dear Admin
		</div>
	</div>
	<div style="clear:both"></div>
	<p><strong>Dear Admin</strong><br></p>
	<p>This is to notify you that a customer has created a new account.</p>
	<p></p>
	<div style="margin:20px 0">
		<table style="float:left;width: 100%;margin-bottom:20px;border: 1px solid #eeeeee;">
			<tbody>
				<tr style="border:1px solid #eeeeee;color:#001e47;font-family:'Droid Serif',serif;font-size:18px">
					<th colspan="2" style="text-align:left;padding:5px;border-bottom:1px solid #ccc">Contact Details</th>
				</tr>
				<tr style="float:left;clear:both">
					<td style="padding:5px;color:#ff9900;font-weight:bold">Name: </td>
					<td> {{ $user->fname }} {{ $user->lname }}</td>
				</tr>
				<tr style="float:left;clear:both">
					<td style="padding:5px;color:#ff9900;font-weight:bold">Email: </td>
					<td> {{ $user->email }}</td>
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