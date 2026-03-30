package com.projet.irannews.repository;

import com.projet.irannews.entity.Article;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ArticleRepository extends JpaRepository<Article, Long> {

    List<Article> findByStatusOrderByCreatedAtDesc(String status);

    List<Article> findAllByOrderByCreatedAtDesc();

    long countByStatus(String status);
}
