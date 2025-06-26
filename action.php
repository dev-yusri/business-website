<?php

include('includes/config.php');

if (isset($_GET["page"])) {
    $data = array();

    $limit = 8;

    $page = 1;

    if ($_GET["page"] > 1) {
        $start = (($_GET["page"] - 1) * $limit);

        $page = $_GET["page"];
    } else {
        $start = 0;
    }

    $where = '';

    $search_query = '';

    if (isset($_GET["gender_filter"])) {
        $where .= ' PaymentType = :gender_filter ';
        $search_query .= '&gender_filter=' . trim($_GET["gender_filter"]);
    }

    if (isset($_GET["search_filter"])) {
        $search_string = str_replace(" ", "%", $_GET["search_filter"]);

        if ($where != '') {
            $where .= ' AND ( name LIKE :search_filter ) ';
        } else {
            $where .= 'name LIKE :search_filter ';
        }
        $search_query .= '&search_filter=' . $_GET["search_filter"] . '';
    }

    if ($where != '') {
        $where = 'WHERE ' . $where;
    }

    $query = "
        SELECT *
        FROM tblvoucher 
        " . $where . "
        ORDER BY id ASC
    ";

    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';

    $statement = $dbh->prepare($query);

    $statement->execute();

    $total_data = $statement->rowCount();

    $statement = $dbh->prepare($filter_query);
    $statement->bindParam(':gender_filter', trim($_GET["gender_filter"]), PDO::PARAM_STR);
    $statement->bindParam(':search_filter', $search_string, PDO::PARAM_STR);

    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $image_array = explode(" ~ ", $row["Vimage1"]);

        $data[] = array(
            'name' => $row['VoucherTitle'],
            'price' => $row['Discount'],
            'brand' => $row['PaymentType'],
            'image' => $image_array[0]
        );
    }

    $pagination_html = '
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
    ';

    $total_links = ceil($total_data / $limit);

    $previous_link = '';

    $next_link = '';

    $page_link = '';

    $page_array = '';

    if($total_links > 4)
	{
		if($page < 5)
		{
			for($count = 1; $count <= 5; $count++)
			{
				$page_array[] = $count;
			}

			$page_array[] = '...';

			$page_array[] = $total_links;
		}
		else
		{
			$end_limit = $total_links - 5;

			if($page > $end_limit)
			{
				$page_array[] = 1;

				$page_array[] = '...';

				for($count = $end_limit; $count <= $total_links; $count++)
				{
					$page_array[] = $count;
				}
			}
			else
			{
				$page_array[] = 1;

				$page_array[] = '...';

				for($count = $page - 1; $count <= $page + 1; $count++)
				{
					$page_array[] = $count;
				}

				$page_array[] = '...';

				$page_array[] = $total_links;
			}
		}
	}
	else
	{
		for($count = 1; $count <= $total_links; $count++)
		{
			$page_array[] = $count;
		}
	}

	for($count = 0; $count < count($page_array); $count++)
	{
		if($page == $page_array[$count])
		{
			$page_link .= '
				<li class="page-item active">
		      		<a class="page-link" href="#">'.$page_array[$count].'</a>
		    	</li>
			';

			$previous_id = $page_array[$count] - 1;

			if($previous_id > 0)
			{
				$previous_link = '<li class="page-item"><a class="page-link" href="javascript:load_product('.$previous_id.', `'.$search_query.'`)">Previous</a></li>';
			}
			else
			{
				$previous_link = '
					<li class="page-item disabled">
				        <a class="page-link" href="#">Previous</a>
				    </li>
				';
			}

			$next_id = $page_array[$count] + 1;

			if($next_id > $total_links)
			{
				$next_link = '
					<li class="page-item disabled">
		        		<a class="page-link" href="#">Next</a>
		      		</li>
				';
			}
			else
			{
				$next_link = '
				<li class="page-item"><a class="page-link" href="javascript:load_product('.$next_id.', `'.$search_query.'`)">Next</a></li>
				';
			}
		}
		else
		{
			if($page_array[$count] == '...')
			{
				$page_link .= '
					<li class="page-item disabled">
		          		<a class="page-link" href="#">...</a>
		      		</li>
				';
			}
			else
			{
				$page_link .= '
					<li class="page-item">
						<a class="page-link" href="javascript:load_product('.$page_array[$count].', `'.$search_query.'`)">'.$page_array[$count].'</a>
					</li>
				';
			}
		}
	}

    $pagination_html .= $previous_link . $page_link . $next_link;

    $pagination_html .= '
            </ul>
        </nav>
    ';

    $output = array(
        'data' => $data,
        'pagination' => $pagination_html,
        'total_data' => $total_data
    );

    echo json_encode($output);
}

if (isset($_GET["action"])) {
    $data = array();

    $query = "
        SELECT PaymentType, COUNT(id) AS Total 
        FROM tblvoucher 
        GROUP BY PaymentType
    ";

    $statement = $dbh->prepare($query);
    $statement->execute();

    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $sub_data = array();
        $sub_data['name'] = $row['PaymentType'];
        $sub_data['total'] = $row['Total'];
        $data['gender'][] = $sub_data;
    }

    echo json_encode($data);
}

?>
