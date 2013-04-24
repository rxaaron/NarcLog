SELECT A.ID AS ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description
	FROM North_Drugs AS A
        INNER JOIN DrugForm AS C ON A.FormID = C.ID
	WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (A.BrandName) AGAINST ('a*' IN BOOLEAN MODE)) 
UNION 
SELECT A.ID AS ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description 
	FROM North_Drugs AS A
        INNER JOIN DrugForm AS C ON A.FormID = C.ID
	WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (A.GenericName) AGAINST ('a*' IN BOOLEAN MODE))
UNION
SELECT A.ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description
	FROM North_Drugs AS A
	INNER JOIN DrugCode AS B ON A.ID = B.DrugID
        INNER JOIN DrugForm AS C ON A.FormID = C.ID
	WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('0*' IN BOOLEAN MODE))
UNION
SELECT A.ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description
	FROM North_Drugs AS A
	INNER JOIN DrugCode AS B ON A.ID = B.DrugID
        INNER JOIN DrugForm AS C ON A.FormID = C.ID
	WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('0*' IN BOOLEAN MODE))
ORDER BY Drug, Strength