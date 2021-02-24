<head>
	<% base_tag %>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <% if $CanonicalUrl %>
        <link rel="canonical" href="$CanonicalUrl" />
    <% end_if %>
	<% if $IsAPIPage %>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha512-oBTprMeNEKCnqfuqKd6sbvFzmFQtlXS3e0C/RGFV0hD6QzhHV+ODfaQbAlmY6/q0ubbwlAM/nCJjkrgA3waLzg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.5/typeahead.bundle.min.js" integrity="sha512-2Scex336zMLyT8q9gO0XjZjIHWZMrLM+zRIglW+mYl0cRFVaC4GoIJQ4DwvpYO0TSM1uvBeztOxWsVypk7fVyw==" crossorigin="anonymous"></script>
		<script src="/resources/directlease/docs/api/js/doctum.js"></script>
	<% end_if %>
	<title><% if Title %>$Title &#8211; <% end_if %>$DocumentationTitle</title>
</head>

<body>
