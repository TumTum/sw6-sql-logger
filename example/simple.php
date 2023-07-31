<?php


\StartSQLLog();

$criteria = new Criteria();
$result = $this->productRepository->search($criteria, Context::createDefaultContext());

\StopSQLLog();
