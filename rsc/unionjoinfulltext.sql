SELECT ID AS ID, BrandName AS Drug, Strength, NULL AS Indicator 
	FROM North_Drugs 
	WHERE ((IsBrand=TRUE AND Active=TRUE) AND MATCH (BrandName) AGAINST ('b*' IN BOOLEAN MODE)) 
UNION 
SELECT ID AS ID, GenericName AS Drug, Strength, Concat('(generic for ',BrandName,')') AS Indicator 
	FROM North_Drugs 
	WHERE ((IsBrand=FALSE AND Active=TRUE) AND MATCH (GenericName) AGAINST ('b*' IN BOOLEAN MODE))
UNION
SELECT A.ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator
	FROM North_Drugs AS A
	INNER JOIN DrugCode AS B ON A.ID = B.DrugID
	WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('0*' IN BOOLEAN MODE))
UNION
SELECT A.ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator
	FROM North_Drugs AS A
	INNER JOIN DrugCode AS B ON A.ID = B.DrugID
	WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('0*' IN BOOLEAN MODE))
ORDER BY Drug, Strength